<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $dari = $request->input('dari', \App\Support\RutoDate::now()->startOfMonth()->format('Y-m-d'));
        $sampai = $request->input('sampai', \App\Support\RutoDate::today()->format('Y-m-d'));

        $transaksi = Transaksi::with('user')
            ->whereBetween('tanggal', [$dari, $sampai])
            ->latest()
            ->get();

        $totalPenjualan = $transaksi->sum('total_harga');
        $totalTransaksi = $transaksi->count();

        return view('laporan.index', compact('transaksi', 'dari', 'sampai', 'totalPenjualan', 'totalTransaksi'));
    }

    public function show(Transaksi $transaksi)
    {
        $transaksi->load(['user', 'details.produk']);

        return view('laporan.show', compact('transaksi'));
    }
}
