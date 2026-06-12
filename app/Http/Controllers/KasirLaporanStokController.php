<?php

namespace App\Http\Controllers;

use App\Models\DetailLaporanStokBaku;
use App\Models\LaporanStokBaku;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KasirLaporanStokController extends Controller
{
    public function index()
    {
        $bahanBaku = Produk::baku()->aktif()->orderBy('nama_produk')->get();

        return view('kasir.laporan-stok.index', compact('bahanBaku'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.produk_id' => 'required|exists:produk,id',
            'items.*.status' => 'required|in:aman,menipis,habis',
            'catatan' => 'nullable|string|max:1000',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                $laporan = LaporanStokBaku::create([
                    'user_id' => auth()->id(),
                    'tanggal' => \App\Support\RutoDate::today(),
                    'catatan' => $validated['catatan'] ?? null,
                ]);

                foreach ($validated['items'] as $item) {
                    // Only save to details if marked as 'menipis' or 'habis'
                    if (in_array($item['status'], ['menipis', 'habis'])) {
                        DetailLaporanStokBaku::create([
                            'laporan_stok_baku_id' => $laporan->id,
                            'produk_id' => $item['produk_id'],
                            'status' => $item['status'],
                        ]);
                    }
                }
            });
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return redirect()
            ->route('kasir.index')
            ->with('success', 'Laporan harian bahan baku berhasil dikirim ke Admin.');
    }
}
