<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
    public function index()
    {
        $produk = Produk::jual()->aktif()->where('stok', '>', 0)->with('kategori')->orderBy('nama_produk')->get();

        return view('kasir.pos', compact('produk'));
    }

    public function search(Request $request)
    {
        $q = $request->input('q', '');

        $produk = Produk::jual()->aktif()
            ->where('stok', '>', 0)
            ->where(function ($query) use ($q) {
                $query->where('nama_produk', 'like', "%{$q}%")
                    ->orWhereHas('kategori', fn ($k) => $k->where('nama_kategori', 'like', "%{$q}%"));
            })
            ->with('kategori')
            ->limit(20)
            ->get();

        return response()->json($produk);
    }

    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.produk_id' => 'required|exists:produk,id',
            'items.*.qty' => 'required|integer|min:1',
            'bayar' => 'required|numeric|min:0',
        ]);

        try {
            $transaksi = DB::transaction(function () use ($validated) {
                $total = 0;
                $details = [];
                $cupQuantities = [];

                foreach ($validated['items'] as $item) {
                    $produk = Produk::lockForUpdate()->findOrFail($item['produk_id']);

                    if ($produk->status !== 'aktif') {
                        throw new \RuntimeException("Produk {$produk->nama_produk} tidak aktif.");
                    }

                    if ($produk->stok < $item['qty']) {
                        throw new \RuntimeException("Stok {$produk->nama_produk} tidak mencukupi.");
                    }

                    if ($produk->cup_id) {
                        $cupQuantities[$produk->cup_id] = ($cupQuantities[$produk->cup_id] ?? 0) + $item['qty'];
                    }

                    $subtotal = $produk->harga_jual * $item['qty'];
                    $total += $subtotal;

                    $details[] = [
                        'produk' => $produk,
                        'qty' => $item['qty'],
                        'harga' => $produk->harga_jual,
                        'subtotal' => $subtotal,
                    ];
                }

                // Check cup stocks
                foreach ($cupQuantities as $cupId => $reqQty) {
                    $cup = Produk::lockForUpdate()->findOrFail($cupId);
                    if ($cup->stok < $reqQty) {
                        throw new \RuntimeException("Stok wadah/cup {$cup->nama_produk} tidak mencukupi untuk memenuhi pesanan ini.");
                    }
                }

                if ($validated['bayar'] < $total) {
                    throw new \RuntimeException('Jumlah bayar kurang dari total.');
                }

                $transaksi = Transaksi::create([
                    'kode_transaksi' => 'TRX-'.now()->format('YmdHis').'-'.random_int(100, 999),
                    'sumber' => 'langsung',
                    'user_id' => auth()->id(),
                    'tanggal' => \App\Support\RutoDate::today(),
                    'total_harga' => $total,
                    'bayar' => $validated['bayar'],
                    'kembalian' => $validated['bayar'] - $total,
                ]);

                foreach ($details as $detail) {
                    DetailTransaksi::create([
                        'transaksi_id' => $transaksi->id,
                        'produk_id' => $detail['produk']->id,
                        'qty' => $detail['qty'],
                        'harga' => $detail['harga'],
                        'subtotal' => $detail['subtotal'],
                    ]);

                    $detail['produk']->decrement('stok', $detail['qty']);

                    if ($detail['produk']->cup_id) {
                        Produk::where('id', $detail['produk']->cup_id)->decrement('stok', $detail['qty']);
                    }
                }

                return $transaksi;
            });
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('kasir.struk', $transaksi)->with('success', 'Transaksi berhasil.');
    }

    public function struk(Transaksi $transaksi)
    {
        if ($transaksi->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $transaksi->load(['user', 'details.produk', 'pesanan']);

        return view('kasir.struk', compact('transaksi'));
    }
}
