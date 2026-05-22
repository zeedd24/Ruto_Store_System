@extends('layouts.admin')

@section('title', 'Laporan Penjualan')

@section('content')
<form method="GET" class="bg-white rounded-lg shadow p-4 mb-4 flex flex-wrap gap-4 items-end">
    <div>
        <label class="block text-sm text-gray-600 mb-1">Dari</label>
        <input type="date" name="dari" value="{{ $dari }}" class="border-gray-300 rounded-md shadow-sm">
    </div>
    <div>
        <label class="block text-sm text-gray-600 mb-1">Sampai</label>
        <input type="date" name="sampai" value="{{ $sampai }}" class="border-gray-300 rounded-md shadow-sm">
    </div>
    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Filter</button>
</form>

<div class="grid grid-cols-2 gap-4 mb-4">
    <div class="bg-white rounded-lg shadow p-4">
        <p class="text-sm text-gray-500">Total Transaksi</p>
        <p class="text-xl font-bold">{{ $totalTransaksi }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <p class="text-sm text-gray-500">Total Penjualan</p>
        <p class="text-xl font-bold text-green-600">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</p>
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left">Kode</th>
                <th class="px-4 py-3 text-left">Tanggal</th>
                <th class="px-4 py-3 text-left">Kasir</th>
                <th class="px-4 py-3 text-right">Total</th>
                <th class="px-4 py-3 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transaksi as $trx)
                <tr class="border-t">
                    <td class="px-4 py-3">{{ $trx->kode_transaksi }}</td>
                    <td class="px-4 py-3">{{ $trx->tanggal->format('d/m/Y') }}</td>
                    <td class="px-4 py-3">{{ $trx->user->name }}</td>
                    <td class="px-4 py-3 text-right">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                    <td class="px-4 py-3">
                        <a href="{{ route('laporan.show', $trx) }}" class="text-indigo-600 hover:underline">Detail</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-gray-500">Tidak ada data pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
