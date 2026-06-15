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
    /* Sembunyikan elemen non-struk */
    .ruto-kasir-header,
    .ruto-kasir-header-actions,
    .ruto-kasir-tabs,
    .ruto-alert,
    .print\:hidden,
    #ruto-theme-toggle,
    header,
    footer,
    nav {
        display: none !important;
    }

    /* Reset warna latar belakang dan teks untuk kompatibilitas cetak (termasuk Dark Mode) */
    html, body {
        background: #ffffff !important;
        color: #000000 !important;
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
        height: auto !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }

    /* Reset container layout utama */
    .ruto-kasir-shell,
    .ruto-kasir-main {
        padding: 0 !important;
        margin: 0 !important;
        border: none !important;
        background: transparent !important;
        box-shadow: none !important;
        display: block !important;
        min-height: auto !important;
    }

    /* Format area struk */
    #struk {
        display: block !important;
        visibility: visible !important;
        margin: 0 auto !important;
        padding: 15px !important;
        border: none !important;
        box-shadow: none !important;
        background: #ffffff !important;
        max-width: 100% !important;
        width: 100% !important;
        box-sizing: border-box !important;
    }

    /* Pastikan semua elemen teks di dalam struk berwarna hitam pekat */
    #struk, #struk * {
        color: #000000 !important;
        background-color: transparent !important;
        box-shadow: none !important;
        text-shadow: none !important;
    }

    /* Maksimalkan keterbacaan gambar logo saat dicetak */
    #struk img {
        display: block !important;
        margin-left: auto !important;
        margin-right: auto !important;
        filter: grayscale(100%) !important;
    }

    /* Gaya pembatas putus-putus untuk struk belanja */
    .border-t {
        border-top: 1px dashed #000000 !important;
    }
}
</style>
@endpush

@push('scripts')
<script>
    // Buka dialog printer secara otomatis ketika halaman struk selesai dimuat
    window.addEventListener('DOMContentLoaded', () => {
        // Berikan delay sangat singkat agar rendering selesai dengan sempurna sebelum print dialog memblokir thread
        setTimeout(() => {
            window.print();
        }, 150);
    });
</script>
@endpush
@endsection
