<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Support\RutoDate;
use Illuminate\Support\Facades\DB;

class GrafikController extends Controller
{
    public function index()
    {
        $labels = [];
        $data = [];
        $sekarang = RutoDate::now();

        for ($i = 6; $i >= 0; $i--) {
            $tanggal = $sekarang->copy()->subDays($i);
            $labels[] = $tanggal->locale(config('app.locale', 'id'))->translatedFormat('d M');
            $data[] = (float) Transaksi::whereDate('tanggal', $tanggal)->sum('total_harga');
        }

        $penjualanBulanIni = Transaksi::whereMonth('tanggal', $sekarang->month)
            ->whereYear('tanggal', $sekarang->year)
            ->sum('total_harga');

        $penjualanPerKategori = DB::table('detail_transaksi')
            ->join('produk', 'detail_transaksi.produk_id', '=', 'produk.id')
            ->join('kategori', 'produk.kategori_id', '=', 'kategori.id')
            ->join('transaksi', 'detail_transaksi.transaksi_id', '=', 'transaksi.id')
            ->whereMonth('transaksi.tanggal', $sekarang->month)
            ->whereYear('transaksi.tanggal', $sekarang->year)
            ->select('kategori.nama_kategori', DB::raw('SUM(detail_transaksi.subtotal) as total'))
            ->groupBy('kategori.id', 'kategori.nama_kategori')
            ->get();

        return view('grafik.index', compact('labels', 'data', 'penjualanBulanIni', 'penjualanPerKategori'));
    }
}
