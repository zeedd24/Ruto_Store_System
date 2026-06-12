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
        $data = [];
        $current = $start->copy();

        while ($current->lte($end)) {
            $labels[] = $current->locale(config('app.locale', 'id'))->translatedFormat('d M');
            $data[] = (float) Transaksi::whereDate('tanggal', $current)->sum('total_harga');
            $current->addDay();
        }

        $penjualanPeriodeIni = Transaksi::whereBetween('tanggal', [$dari, $sampai])
            ->sum('total_harga');

        $penjualanPerKategori = DB::table('detail_transaksi')
            ->join('produk', 'detail_transaksi.produk_id', '=', 'produk.id')
            ->join('kategori', 'produk.kategori_id', '=', 'kategori.id')
            ->join('transaksi', 'detail_transaksi.transaksi_id', '=', 'transaksi.id')
            ->whereBetween('transaksi.tanggal', [$dari, $sampai])
            ->select('kategori.nama_kategori', DB::raw('SUM(detail_transaksi.subtotal) as total'))
            ->groupBy('kategori.id', 'kategori.nama_kategori')
            ->get();

        return view('grafik.index', compact('labels', 'data', 'penjualanPeriodeIni', 'penjualanPerKategori', 'dari', 'sampai'));
    }
}
