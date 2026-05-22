<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class GrafikController extends Controller
{
    public function index()
    {
        $labels = [];
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $tanggal = now()->subDays($i);
            $labels[] = $tanggal->format('d M');
            $data[] = (float) Transaksi::whereDate('tanggal', $tanggal)->sum('total_harga');
        }

        $penjualanBulanIni = Transaksi::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->sum('total_harga');

        $penjualanPerKategori = DB::table('detail_transaksi')
            ->join('produk', 'detail_transaksi.produk_id', '=', 'produk.id')
            ->join('kategori', 'produk.kategori_id', '=', 'kategori.id')
            ->join('transaksi', 'detail_transaksi.transaksi_id', '=', 'transaksi.id')
            ->whereMonth('transaksi.tanggal', now()->month)
            ->whereYear('transaksi.tanggal', now()->year)
            ->select('kategori.nama_kategori', DB::raw('SUM(detail_transaksi.subtotal) as total'))
            ->groupBy('kategori.id', 'kategori.nama_kategori')
            ->get();

        return view('grafik.index', compact('labels', 'data', 'penjualanBulanIni', 'penjualanPerKategori'));
    }
}
