<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Transaksi;
class DashboardController extends Controller
{
    public function index()
    {
        $totalProduk = Produk::count();
        $totalKategori = Kategori::count();

        $transaksiHariIni = Transaksi::whereDate('tanggal', today());
        $jumlahTransaksiHariIni = $transaksiHariIni->count();
        $penjualanHariIni = $transaksiHariIni->sum('total_harga');

        $stokRendah = Produk::aktif()
            ->where('stok', '<', 10)
            ->orderBy('stok')
            ->limit(5)
            ->get();

        $penjualanTerbaru = Transaksi::with('user')
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalProduk',
            'totalKategori',
            'jumlahTransaksiHariIni',
            'penjualanHariIni',
            'stokRendah',
            'penjualanTerbaru'
        ));
    }
}
