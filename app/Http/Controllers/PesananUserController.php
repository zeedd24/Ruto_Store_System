<?php

namespace App\Http\Controllers;

use App\Models\DetailPesanan;
use App\Models\Kategori;
use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PesananUserController extends Controller
{
    public function index()
    {
        $produk = Produk::jual()->aktif()->where('stok', '>', 0)->with('kategori')->orderBy('nama_produk')->get();
        $kategori = Kategori::whereHas('produk', function ($q) {
            $q->jual()->aktif()->where('stok', '>', 0);
        })->orderBy('nama_kategori')->get();
        $traffic = $this->trafficByProduk();

        $produk = $produk->map(function (Produk $p) use ($traffic) {
            $p->setAttribute('total_terjual', (int) ($traffic[$p->id] ?? 0));

            return $p;
        });

        $terlaris = $produk
            ->sortByDesc('total_terjual')
            ->take(10)
            ->values();

        return view('pesan.index', compact('produk', 'kategori', 'terlaris'));
    }

    /** @return array<int, int> produk_id => total qty terjual */
    private function trafficByProduk(): array
    {
        $merged = [];

        foreach (DB::table('detail_transaksi')->select('produk_id', DB::raw('SUM(qty) as total'))->groupBy('produk_id')->get() as $row) {
            $merged[$row->produk_id] = ($merged[$row->produk_id] ?? 0) + (int) $row->total;
        }

        foreach (DB::table('detail_pesanan')->select('produk_id', DB::raw('SUM(qty) as total'))->groupBy('produk_id')->get() as $row) {
            $merged[$row->produk_id] = ($merged[$row->produk_id] ?? 0) + (int) $row->total;
        }

        return $merged;
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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_meja' => 'required|string|max:50',
            'items' => 'required|array|min:1',
            'items.*.produk_id' => 'required|exists:produk,id',
            'items.*.qty' => 'required|integer|min:1',
            'catatan' => 'nullable|string|max:500',
        ]);

        try {
            $pesanan = DB::transaction(function () use ($validated) {
                $total = 0;
                $lines = [];

                foreach ($validated['items'] as $item) {
                    $produk = Produk::lockForUpdate()->findOrFail($item['produk_id']);

                    if ($produk->status !== 'aktif') {
                        throw new \RuntimeException("Produk {$produk->nama_produk} tidak tersedia.");
                    }

                    if ($produk->stok < $item['qty']) {
                        throw new \RuntimeException("Stok {$produk->nama_produk} tidak mencukupi.");
                    }

                    $subtotal = $produk->harga_jual * $item['qty'];
                    $total += $subtotal;

                    $lines[] = [
                        'produk' => $produk,
                        'qty' => $item['qty'],
                        'harga' => $produk->harga_jual,
                        'subtotal' => $subtotal,
                    ];
                }

                $pesanan = Pesanan::create([
                    'kode_pesanan' => Pesanan::generateKode(),
                    'jenis_identitas' => 'meja',
                    'nomor_identitas' => trim($validated['nomor_meja']),
                    'status' => 'menunggu_bayar',
                    'total_harga' => $total,
                    'catatan' => $validated['catatan'] ?? null,
                ]);

                foreach ($lines as $line) {
                    DetailPesanan::create([
                        'pesanan_id' => $pesanan->id,
                        'produk_id' => $line['produk']->id,
                        'qty' => $line['qty'],
                        'harga' => $line['harga'],
                        'subtotal' => $line['subtotal'],
                    ]);
                }

                return $pesanan;
            });
        } catch (\RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()
            ->route('pesan.sukses', $pesanan)
            ->with('success', 'Pesanan berhasil dikirim. Silakan bayar di kasir.');
    }

    public function sukses(Pesanan $pesanan)
    {
        if ($pesanan->status !== 'menunggu_bayar') {
            return redirect()->route('pesan.index');
        }

        $pesanan->load('details.produk');

        return view('pesan.sukses', compact('pesanan'));
    }
}
