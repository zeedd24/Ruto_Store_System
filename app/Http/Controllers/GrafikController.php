<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Support\RutoDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GrafikController extends Controller
{
    public function index(Request $request)
    {
        $dari = $request->input('dari', RutoDate::now()->subDays(6)->format('Y-m-d'));
        $sampai = $request->input('sampai', RutoDate::today()->format('Y-m-d'));

        $start = \Illuminate\Support\Carbon::parse($dari);
        $end = \Illuminate\Support\Carbon::parse($sampai);

        // Limit date range to prevent chart clutter (max 31 days)
        if ($start->diffInDays($end) > 31) {
            $start = $end->copy()->subDays(30);
            $dari = $start->format('Y-m-d');
        }

        $labels = [];
        $dataPenjualan = [];
        $dataTransaksi = [];
        $current = $start->copy();

        while ($current->lte($end)) {
            $labels[] = $current->locale(config('app.locale', 'id'))->translatedFormat('d M');
            $dataPenjualan[] = (float) Transaksi::whereDate('tanggal', $current)->sum('total_harga');
            $dataTransaksi[] = Transaksi::whereDate('tanggal', $current)->count();
            $current->addDay();
        }

        $penjualanPeriodeIni = Transaksi::whereBetween('tanggal', [$dari, $sampai])
            ->sum('total_harga');

        $totalTransaksi = Transaksi::whereBetween('tanggal', [$dari, $sampai])
            ->count();

        $rataRataTransaksi = $totalTransaksi > 0 ? ($penjualanPeriodeIni / $totalTransaksi) : 0;

        $totalProdukTerjual = (int) DB::table('detail_transaksi')
            ->join('transaksi', 'detail_transaksi.transaksi_id', '=', 'transaksi.id')
            ->whereBetween('transaksi.tanggal', [$dari, $sampai])
            ->sum('detail_transaksi.qty');

        $penjualanPerKategori = DB::table('detail_transaksi')
            ->join('produk', 'detail_transaksi.produk_id', '=', 'produk.id')
            ->join('kategori', 'produk.kategori_id', '=', 'kategori.id')
            ->join('transaksi', 'detail_transaksi.transaksi_id', '=', 'transaksi.id')
            ->whereBetween('transaksi.tanggal', [$dari, $sampai])
            ->select('kategori.nama_kategori', DB::raw('SUM(detail_transaksi.subtotal) as total'))
            ->groupBy('kategori.id', 'kategori.nama_kategori')
            ->get();

        $produkTerlaris = DB::table('detail_transaksi')
            ->join('produk', 'detail_transaksi.produk_id', '=', 'produk.id')
            ->join('transaksi', 'detail_transaksi.transaksi_id', '=', 'transaksi.id')
            ->whereBetween('transaksi.tanggal', [$dari, $sampai])
            ->select('produk.nama_produk', DB::raw('SUM(detail_transaksi.qty) as total_qty'))
            ->groupBy('produk.id', 'produk.nama_produk')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        $sumberPesanan = DB::table('transaksi')
            ->whereBetween('tanggal', [$dari, $sampai])
            ->select('sumber', DB::raw('count(*) as total'))
            ->groupBy('sumber')
            ->get();

        return view('grafik.index', compact(
            'labels',
            'dataPenjualan',
            'dataTransaksi',
            'penjualanPeriodeIni',
            'totalTransaksi',
            'rataRataTransaksi',
            'totalProdukTerjual',
            'penjualanPerKategori',
            'produkTerlaris',
            'sumberPesanan',
            'dari',
            'sampai'
        ));
    }
}
