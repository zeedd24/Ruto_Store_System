@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-4">
        <p class="text-sm text-gray-500">Total Produk</p>
        <p class="text-2xl font-bold text-indigo-700">{{ $totalProduk }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <p class="text-sm text-gray-500">Total Kategori</p>
        <p class="text-2xl font-bold text-indigo-700">{{ $totalKategori }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <p class="text-sm text-gray-500">Transaksi Hari Ini</p>
        <p class="text-2xl font-bold text-indigo-700">{{ $jumlahTransaksiHariIni }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <p class="text-sm text-gray-500">Penjualan Hari Ini</p>
        <p class="text-2xl font-bold text-green-600">Rp {{ number_format($penjualanHariIni, 0, ',', '.') }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow p-4">
        <h3 class="font-semibold mb-3">Stok Rendah (&lt; 10)</h3>
        @forelse ($stokRendah as $item)
            <div class="flex justify-between py-2 border-b text-sm">
                <span>{{ $item->nama_produk }}</span>
                <span class="text-red-600 font-medium">{{ $item->stok }} unit</span>
            </div>
        @empty
            <p class="text-gray-500 text-sm">Semua stok aman.</p>
        @endforelse
    </div>

    <div class="bg-white rounded-lg shadow p-4">
        <h3 class="font-semibold mb-3">Penjualan Terbaru</h3>
        @forelse ($penjualanTerbaru as $trx)
            <div class="flex justify-between py-2 border-b text-sm">
                <span>{{ $trx->kode_transaksi }} — {{ $trx->user->name }}</span>
                <span>Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</span>
            </div>
        @empty
            <p class="text-gray-500 text-sm">Belum ada transaksi.</p>
        @endforelse
    </div>
</div>
@endsection
