<?php

namespace App\Http\Controllers;

use App\Models\LaporanStokBaku;
use Illuminate\Http\Request;

class AdminLaporanStokController extends Controller
{
    public function index()
    {
        $reports = LaporanStokBaku::with(['user', 'details'])->latest()->get();

        return view('admin.laporan-stok.index', compact('reports'));
    }

    public function show(LaporanStokBaku $laporan)
    {
        $laporan->load(['user', 'details.produk.kategori']);

        return view('admin.laporan-stok.show', compact('laporan'));
    }

    public function print(LaporanStokBaku $laporan)
    {
        $laporan->load(['user', 'details.produk.kategori']);

        return view('admin.laporan-stok.print', compact('laporan'));
    }
}
