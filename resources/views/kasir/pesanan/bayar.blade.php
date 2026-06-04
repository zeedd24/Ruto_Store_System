@extends('layouts.kasir')

@section('title', 'Bayar Pesanan User')

@section('content')
<x-kasir.nav-tabs />

<div class="max-w-lg mx-auto mt-4">
    <div class="ruto-card ruto-card-padded">
        <a href="{{ route('kasir.pesanan.index') }}" class="text-sm mb-3 inline-block" style="color:var(--ruto-brand-dark)">← Kembali</a>

        <h2 class="ruto-card-title">Bayar Pesanan User</h2>

        <div class="mb-4 p-3 rounded-lg" style="background:var(--ruto-brand-soft)">
            <p class="font-semibold text-lg" style="color:var(--ruto-text)">{{ $pesanan->label_identitas }}</p>
            <p class="text-sm" style="color:var(--ruto-text-muted)">{{ $pesanan->kode_pesanan }}</p>
        </div>

        <table class="ruto-table w-full text-sm mb-4">
            @foreach ($pesanan->details as $detail)
                <tr>
                    <td class="py-1">{{ $detail->produk->nama_produk }}</td>
                    <td class="py-1 text-right">{{ $detail->qty }} × {{ number_format($detail->harga, 0, ',', '.') }}</td>
                    <td class="py-1 text-right w-24">{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </table>

        <div class="ruto-pos-total-row mb-4">
            <span>Total Tagihan</span>
            <span>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
        </div>

        <form method="POST" action="{{ route('kasir.pesanan.checkout', $pesanan) }}">
            @csrf
            <div class="ruto-field">
                <label>Jumlah Bayar</label>
                <input type="number" name="bayar" min="{{ (int) $pesanan->total_harga }}" step="100" class="ruto-input" required
                    value="{{ (int) $pesanan->total_harga }}">
            </div>
            <button type="submit" class="ruto-btn-primary w-full justify-center mt-3" style="width:100%;justify-content:center;padding:0.85rem">
                Selesaikan Pembayaran
            </button>
        </form>
    </div>
</div>
@endsection
