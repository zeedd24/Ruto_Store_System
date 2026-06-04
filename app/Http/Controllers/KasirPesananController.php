<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KasirPesananController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::menungguBayar()
            ->with('details.produk')
            ->latest()
            ->get();

        return view('kasir.pesanan.index', compact('pesanan'));
    }

    public function bayar(Pesanan $pesanan)
    {
        if ($pesanan->status !== 'menunggu_bayar') {
            return redirect()->route('kasir.pesanan.index')->with('error', 'Pesanan sudah diproses.');
        }

        $pesanan->load('details.produk');

        return view('kasir.pesanan.bayar', compact('pesanan'));
    }

    public function checkout(Request $request, Pesanan $pesanan)
    {
        if ($pesanan->status !== 'menunggu_bayar') {
            return redirect()->route('kasir.pesanan.index')->with('error', 'Pesanan sudah diproses.');
        }

        $validated = $request->validate([
            'bayar' => 'required|numeric|min:0',
        ]);

        $pesanan->load('details.produk');

        try {
            $transaksi = DB::transaction(function () use ($pesanan, $validated) {
                $total = (float) $pesanan->total_harga;

                if ($validated['bayar'] < $total) {
                    throw new \RuntimeException('Jumlah bayar kurang dari total.');
                }

                foreach ($pesanan->details as $detail) {
                    $produk = Produk::lockForUpdate()->findOrFail($detail->produk_id);

                    if ($produk->stok < $detail->qty) {
                        throw new \RuntimeException("Stok {$produk->nama_produk} tidak mencukupi.");
                    }
                }

                $transaksi = Transaksi::create([
                    'kode_transaksi' => 'TRX-'.now()->format('YmdHis').'-'.random_int(100, 999),
                    'sumber' => 'pesanan_user',
                    'pesanan_id' => $pesanan->id,
                    'user_id' => auth()->id(),
                    'tanggal' => \App\Support\RutoDate::today(),
                    'total_harga' => $total,
                    'bayar' => $validated['bayar'],
                    'kembalian' => $validated['bayar'] - $total,
                ]);

                foreach ($pesanan->details as $detail) {
                    DetailTransaksi::create([
                        'transaksi_id' => $transaksi->id,
                        'produk_id' => $detail->produk_id,
                        'qty' => $detail->qty,
                        'harga' => $detail->harga,
                        'subtotal' => $detail->subtotal,
                    ]);

                    Produk::where('id', $detail->produk_id)->decrement('stok', $detail->qty);
                }

                $pesanan->update(['status' => 'dibayar']);

                return $transaksi;
            });
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()
            ->route('kasir.struk', $transaksi)
            ->with('success', 'Pembayaran pesanan '.$pesanan->label_identitas.' berhasil.')
            ->with('kasir_tab', 'pesanan');
    }

    public function batalkan(Pesanan $pesanan)
    {
        if ($pesanan->status !== 'menunggu_bayar') {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan.');
        }

        $pesanan->update(['status' => 'dibatalkan']);

        return back()->with('success', 'Pesanan dibatalkan.');
    }
}
