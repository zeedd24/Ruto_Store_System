@extends('layouts.kasir')

@section('title', 'Struk Transaksi')

@section('content')
<x-kasir.nav-tabs />

<div class="ruto-card ruto-card-padded max-w-md mx-auto mt-4" id="struk">
    <div class="text-center mb-4">
        <x-ruto-logo class="w-16 h-16 mx-auto mb-2" alt="RUTO" />
        <p class="text-sm" style="color:var(--ruto-text-muted)">{{ $transaksi->kode_transaksi }}</p>
        <p class="text-xs" style="color:var(--ruto-text-muted)">{{ \App\Support\RutoDate::formatDisplay($transaksi->created_at, 'd/m/Y H:i') }} — {{ $transaksi->user->name }}</p>
        @if ($transaksi->isDariPesananUser() && $transaksi->pesanan)
            <p class="text-sm font-medium mt-2" style="color:var(--ruto-brand-dark)">
                Pesanan User: {{ $transaksi->pesanan->label_identitas }}
            </p>
        @else
            <p class="text-xs mt-1" style="color:var(--ruto-text-muted)">Kasir Langsung</p>
        @endif
    </div>

    <table class="ruto-table w-full text-sm mb-4">
        @foreach ($transaksi->details as $detail)
            <tr>
                <td class="py-1" style="color:var(--ruto-text)">{{ $detail->produk->nama_produk }}</td>
                <td class="py-1 text-right" style="color:var(--ruto-text-muted)">{{ $detail->qty }} x {{ number_format($detail->harga, 0, ',', '.') }}</td>
                <td class="py-1 text-right w-24" style="color:var(--ruto-text)">{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </table>

    <div class="text-sm space-y-1 border-t pt-3" style="border-color:rgba(230,162,39,0.2)">
        <div class="flex justify-between font-semibold" style="color:var(--ruto-text)">
            <span>Total</span>
            <span>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between" style="color:var(--ruto-text-muted)">
            <span>Bayar</span>
            <span>Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between" style="color:var(--ruto-text-muted)">
            <span>Kembalian</span>
            <span>Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</span>
        </div>
    </div>

    <p class="text-center text-xs mt-6" style="color:var(--ruto-text-muted)">Terima kasih atas kunjungan Anda</p>
</div>

<div class="max-w-md mx-auto mt-4 flex gap-2 print:hidden">
    <button type="button" onclick="window.print()" class="ruto-btn-primary flex-1 justify-center">Cetak Struk</button>
    <a href="{{ route('kasir.index') }}" class="ruto-btn-secondary flex-1 justify-center text-center">Transaksi Baru</a>
</div>

@push('styles')
<style>
@media print {
    body * { visibility: hidden; }
    #struk, #struk * { visibility: visible; }
    #struk { position: absolute; left: 0; top: 0; width: 100%; }
    .ruto-kasir-header, .ruto-kasir-header-actions { display: none !important; }
}
</style>
@endpush
@endsection
