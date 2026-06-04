@extends('layouts.kasir')

@section('title', 'Pesanan User')

@section('content')
<x-kasir.nav-tabs />

<div class="ruto-page-header" style="margin-top:1rem">
    <p class="ruto-page-desc">Pesanan dari scan QR / halaman user — menunggu pembayaran di kasir.</p>
</div>

@if ($pesanan->isEmpty())
    <div class="ruto-card ruto-card-padded ruto-empty text-center">
        Belum ada pesanan user yang menunggu bayar.
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        @foreach ($pesanan as $item)
            <div class="ruto-card ruto-card-padded">
                <div class="flex items-start justify-between gap-2 mb-2">
                    <div>
                        <span class="text-xs font-medium px-2 py-0.5 rounded-full" style="background:var(--ruto-brand-soft);color:var(--ruto-brand-dark)">
                            {{ $item->label_identitas }}
                        </span>
                        <p class="text-xs mt-1" style="color:var(--ruto-text-muted)">{{ $item->kode_pesanan }}</p>
                    </div>
                    <p class="font-semibold" style="color:var(--ruto-brand-dark)">
                        Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                    </p>
                </div>
                <ul class="text-sm mb-3 space-y-0.5" style="color:var(--ruto-text-muted)">
                    @foreach ($item->details as $detail)
                        <li>{{ $detail->produk->nama_produk }} × {{ $detail->qty }}</li>
                    @endforeach
                </ul>
                @if ($item->catatan)
                    <p class="text-xs mb-3 italic" style="color:var(--ruto-text-muted)">Catatan: {{ $item->catatan }}</p>
                @endif
                <p class="text-xs mb-3" style="color:var(--ruto-text-muted)">{{ $item->created_at->diffForHumans() }}</p>
                <div class="flex gap-2">
                    <a href="{{ route('kasir.pesanan.bayar', $item) }}" class="ruto-btn-primary flex-1 justify-center text-center" style="flex:1;justify-content:center">
                        Bayar
                    </a>
                    <form method="POST" action="{{ route('kasir.pesanan.batalkan', $item) }}" onsubmit="return confirm('Batalkan pesanan ini?')">
                        @csrf
                        <button type="submit" class="ruto-btn-secondary text-sm">Batal</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
