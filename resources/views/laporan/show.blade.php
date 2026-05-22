@extends('layouts.admin')

@section('title', 'Detail Transaksi')

@section('content')
<div class="mb-4">
    <a href="{{ route('laporan.index') }}" class="text-indigo-600 hover:underline">&larr; Kembali ke laporan</a>
</div>

<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <div class="mb-4 text-sm text-gray-600 space-y-1">
        <p><strong>Kode:</strong> {{ $transaksi->kode_transaksi }}</p>
        <p><strong>Tanggal:</strong> {{ $transaksi->tanggal->format('d/m/Y') }}</p>
        <p><strong>Kasir:</strong> {{ $transaksi->user->name }}</p>
    </div>

    <table class="min-w-full text-sm border">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-3 py-2 text-left">Produk</th>
                <th class="px-3 py-2 text-right">Qty</th>
                <th class="px-3 py-2 text-right">Harga</th>
                <th class="px-3 py-2 text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksi->details as $detail)
                <tr class="border-t">
                    <td class="px-3 py-2">{{ $detail->produk->nama_produk }}</td>
                    <td class="px-3 py-2 text-right">{{ $detail->qty }}</td>
                    <td class="px-3 py-2 text-right">Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                    <td class="px-3 py-2 text-right">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot class="bg-gray-50 font-medium">
            <tr>
                <td colspan="3" class="px-3 py-2 text-right">Total</td>
                <td class="px-3 py-2 text-right">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="3" class="px-3 py-2 text-right">Bayar / Kembalian</td>
                <td class="px-3 py-2 text-right">
                    Rp {{ number_format($transaksi->bayar, 0, ',', '.') }} /
                    Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}
                </td>
            </tr>
        </tfoot>
    </table>
</div>
@endsection
