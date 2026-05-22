<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::with('kategori')->latest()->get();

        return view('produk.index', compact('produk'));
    }

    public function create()
    {
        $kategori = Kategori::orderBy('nama_kategori')->get();

        return view('produk.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'nama_produk' => 'required|string|max:255',
            'harga_modal' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        Produk::create($data);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Produk $produk)
    {
        $kategori = Kategori::orderBy('nama_kategori')->get();

        return view('produk.edit', compact('produk', 'kategori'));
    }

    public function update(Request $request, Produk $produk)
    {
        $data = $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'nama_produk' => 'required|string|max:255',
            'harga_modal' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $produk->update($data);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Produk $produk)
    {
        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}
