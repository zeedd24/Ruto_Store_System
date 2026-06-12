@extends('layouts.admin')

@section('title', 'Detail Laporan Stok')

@section('content')
<div class="mb-4 flex justify-between items-center ruto-fade-in">
    <div>
        <a href="{{ route('admin.laporan-stok.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700" style="text-decoration:none">&larr; Kembali ke daftar</a>
        <h2 class="text-xl font-bold mt-1" style="color:var(--ruto-text)">Laporan Stok: {{ \Carbon\Carbon::parse($laporan->tanggal)->format('d F Y') }}</h2>
    </div>
    <a href="{{ route('admin.laporan-stok.print', $laporan) }}" target="_blank" class="ruto-btn-primary" style="padding:0.6rem 1.2rem;text-decoration:none">
        Cetak Shopping List
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 ruto-fade-in-delay-1">
    <div class="md:col-span-1 space-y-4">
        <div class="ruto-card ruto-card-padded">
            <h3 class="font-bold text-sm text-gray-400 uppercase tracking-wider mb-3">Informasi Laporan</h3>
            <div class="space-y-3">
                <div>
                    <span class="block text-xs text-gray-400">Tanggal Pengiriman</span>
                    <span class="text-sm font-medium" style="color:var(--ruto-text)">{{ \Carbon\Carbon::parse($laporan->tanggal)->format('d/m/Y') }}</span>
                </div>
                <div>
                    <span class="block text-xs text-gray-400">Dilaporkan Oleh</span>
                    <span class="text-sm font-medium" style="color:var(--ruto-text)">{{ $laporan->user->name }}</span>
                </div>
                <div>
                    <span class="block text-xs text-gray-400">Waktu Kirim</span>
                    <span class="text-sm font-medium" style="color:var(--ruto-text)">{{ $laporan->created_at->format('H:i') }} WIB</span>
                </div>
            </div>
        </div>

        <div class="ruto-card ruto-card-padded">
            <h3 class="font-bold text-sm text-gray-400 uppercase tracking-wider mb-3">Catatan Kasir</h3>
            <p class="text-sm" style="color:var(--ruto-text)">
                {{ $laporan->catatan ?? 'Tidak ada catatan tambahan.' }}
            </p>
        </div>
    </div>

    <div class="md:col-span-2">
        <div class="ruto-card">
            <div class="ruto-table-wrap">
                <table class="ruto-table">
                    <thead>
                        <tr>
                            <th>Bahan Baku</th>
                            <th>Kategori</th>
                            <th>Status Laporan</th>
                            <th class="text-right">Stok Sistem</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($laporan->details as $detail)
                            <tr>
                                <td class="font-medium" style="color:var(--ruto-text)">{{ $detail->produk->nama_produk }}</td>
                                <td style="color:var(--ruto-text)">{{ $detail->produk->kategori->nama_kategori }}</td>
                                <td>
                                    @if ($detail->status === 'habis')
                                        <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                            Habis
                                        </span>
                                    @else
                                        <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full bg-amber-100 text-amber-800">
                                            Menipis
                                        </span>
                                    @endif
                                </td>
                                <td class="text-right font-semibold" style="color:var(--ruto-text)">{{ $detail->produk->stok }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="ruto-empty py-8 text-center" style="color:var(--ruto-text-muted)">
                                    Semua stok bahan baku aman. Tidak ada item yang menipis atau habis.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
