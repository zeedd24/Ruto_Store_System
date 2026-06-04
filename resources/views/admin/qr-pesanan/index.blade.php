@extends('layouts.admin')

@section('title', 'QR Pesanan User')

@section('content')
<div class="ruto-page-header">
    <div>
        <p class="ruto-page-desc">Scan QR ini untuk membuka halaman pesan pelanggan (tanpa login).</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="ruto-card ruto-card-padded text-center">
        <h3 class="ruto-card-title">QR Code Pesan Online</h3>
        <img
            src="https://api.qrserver.com/v1/create-qr-code/?size=280x280&data={{ urlencode($pesanUrl) }}"
            alt="QR Pesan Online"
            class="mx-auto rounded-lg border"
            style="border-color:rgba(230,162,39,0.3);max-width:280px;width:100%"
            width="280"
            height="280"
        >
        <p class="text-sm mt-4 break-all" style="color:var(--ruto-text-muted)">{{ $pesanUrl }}</p>
        <a href="{{ $pesanUrl }}" target="_blank" rel="noopener" class="ruto-btn-secondary mt-3 inline-flex">Buka Halaman Pesan</a>
    </div>

    <div class="ruto-card ruto-card-padded">
        <h3 class="ruto-card-title">Cara Pakai</h3>
        <ol class="text-sm space-y-3 list-decimal list-inside" style="color:var(--ruto-text-muted)">
            <li>Cetak atau tampilkan QR di meja / dekat kasir.</li>
            <li>Pelanggan scan → pilih <strong>Meja</strong> atau <strong>Antrian</strong> + isi nomor.</li>
            <li>Pelanggan pilih menu dan kirim pesanan (belum bayar).</li>
            <li>Di kasir, buka tab <strong>Pesanan User</strong> → proses pembayaran.</li>
            <li>Checkout langsung di tab <strong>Kasir Langsung</strong> untuk pelanggan walk-in.</li>
        </ol>
        <div class="ruto-alert ruto-alert-info mt-4 text-sm">
            Stok produk akan berkurang saat kasir menyelesaikan pembayaran, bukan saat pesanan dikirim.
        </div>
    </div>
</div>
@endsection
