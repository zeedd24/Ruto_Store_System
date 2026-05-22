<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\StokMasuk;
use Illuminate\Http\Request;

class StokController extends Controller
{
    public function index()
    {
        $produk = Produk::with('kategori')->orderBy('nama_produk')->get();
        $riwayat = StokMasuk::with('produk')->latest()->limit(20)->get();

        return view('stok.index', compact('produk', 'riwayat'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string|max:500',
        ]);

        StokMasuk::create($data);

        Produk::where('id', $data['produk_id'])->increment('stok', $data['jumlah']);

        return redirect()->route('stok.index')->with('success', 'Stok berhasil ditambahkan.');
    }
}
