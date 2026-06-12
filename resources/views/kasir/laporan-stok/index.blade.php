@extends('layouts.kasir')

@section('title', 'Lapor Stok Bahan')

@section('content')
<x-kasir.nav-tabs />

<div class="mt-4 ruto-fade-in">
    <div class="ruto-card ruto-card-padded">
        <div class="mb-6">
            <h2 class="ruto-card-title text-lg font-bold">Laporan Harian Stok Bahan Baku</h2>
            <p class="text-sm mt-1" style="color:var(--ruto-text-muted)">
                Silakan laporkan kondisi bahan baku dapur/wadah yang menipis atau habis sebelum toko tutup.
            </p>
        </div>

        <form action="{{ route('kasir.laporan-stok.store') }}" method="POST">
            @csrf

            <div class="ruto-table-wrap mb-6">
                <table class="ruto-table">
                    <thead>
                        <tr>
                            <th class="text-left py-3 px-4">Nama Bahan Baku</th>
                            <th class="text-right py-3 px-4">Stok Sistem</th>
                            <th class="text-center py-3 px-4" style="width: 15%">Aman</th>
                            <th class="text-center py-3 px-4" style="width: 15%">Menipis</th>
                            <th class="text-center py-3 px-4" style="width: 15%">Habis</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bahanBaku as $index => $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                <td class="py-3 px-4 font-medium" style="color:var(--ruto-text)">
                                    {{ $item->nama_produk }}
                                    <input type="hidden" name="items[{{ $index }}][produk_id]" value="{{ $item->id }}">
                                </td>
                                <td class="py-3 px-4 text-right" style="color:var(--ruto-text)">{{ $item->stok }}</td>
                                <td class="py-3 px-4 text-center">
                                    <label class="inline-flex items-center justify-center cursor-pointer p-2 w-full">
                                        <input type="radio" name="items[{{ $index }}][status]" value="aman" checked class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 dark:border-gray-600">
                                    </label>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <label class="inline-flex items-center justify-center cursor-pointer p-2 w-full">
                                        <input type="radio" name="items[{{ $index }}][status]" value="menipis" class="h-4 w-4 text-amber-500 focus:ring-amber-500 border-gray-300 dark:border-gray-600">
                                    </label>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <label class="inline-flex items-center justify-center cursor-pointer p-2 w-full">
                                        <input type="radio" name="items[{{ $index }}][status]" value="habis" class="h-4 w-4 text-rose-600 focus:ring-rose-500 border-gray-300 dark:border-gray-600">
                                    </label>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="ruto-empty py-6 text-center" style="color:var(--ruto-text-muted)">
                                    Tidak ada bahan baku yang terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="ruto-field mb-6">
                <label style="color:var(--ruto-text)">Catatan Tambahan (Opsional)</label>
                <textarea name="catatan" rows="3" class="ruto-input" placeholder="Tulis catatan jika ada bahan baku lain yang rusak atau butuh perhatian khusus..."></textarea>
                @error('catatan')<p class="ruto-field-error">{{ $message }}</p>@enderror
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('kasir.index') }}" class="ruto-btn-secondary" style="padding:0.6rem 1.2rem;text-decoration:none">Batal</a>
                <button type="submit" class="ruto-btn-primary" style="padding:0.6rem 1.2rem">Kirim Laporan</button>
            </div>
        </form>
    </div>
</div>
@endsection
