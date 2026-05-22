@extends('layouts.kasir')

@section('title', 'Struk Transaksi')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg shadow p-6 print:shadow-none" id="struk">
    <div class="text-center mb-4">
        <h2 class="text-lg font-bold">Ruto Store</h2>
        <p class="text-sm text-gray-500">{{ $transaksi->kode_transaksi }}</p>
        <p class="text-xs text-gray-400">{{ $transaksi->tanggal->format('d/m/Y H:i') }} — {{ $transaksi->user->name }}</p>
    </div>

    <table class="w-full text-sm mb-4">
        @foreach ($transaksi->details as $detail)
            <tr class="border-b">
                <td class="py-1">{{ $detail->produk->nama_produk }}</td>
                <td class="py-1 text-right">{{ $detail->qty }} x {{ number_format($detail->harga, 0, ',', '.') }}</td>
                <td class="py-1 text-right w-24">{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </table>

    <div class="text-sm space-y-1 border-t pt-3">
        <div class="flex justify-between font-semibold">
            <span>Total</span>
            <span>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between">
            <span>Bayar</span>
            <span>Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between">
            <span>Kembalian</span>
            <span>Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</span>
        </div>
    </div>

    <p class="text-center text-xs text-gray-400 mt-6">Terima kasih atas kunjungan Anda</p>
</div>

<div class="max-w-md mx-auto mt-4 flex gap-2 print:hidden">
    <button onclick="window.print()" class="flex-1 bg-emerald-600 text-white py-2 rounded hover:bg-emerald-700">Cetak Struk</button>
    <a href="{{ route('kasir.index') }}" class="flex-1 text-center border py-2 rounded text-gray-700 hover:bg-gray-50">Transaksi Baru</a>
</div>

<style>
@media print {
    body * { visibility: hidden; }
    #struk, #struk * { visibility: visible; }
    #struk { position: absolute; left: 0; top: 0; width: 100%; }
}
</style>
@endsection
