@extends('layouts.admin')

@section('title', 'Produk')

@section('content')
<div class="ruto-page-header ruto-fade-in">
    <p class="ruto-page-desc">Kelola data produk</p>
    <a href="{{ route('produk.create') }}" class="ruto-btn-primary">+ Tambah Produk</a>
</div>

<div class="ruto-card ruto-fade-in-delay-1">
    <div class="ruto-table-wrap">
        <table class="ruto-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Tipe</th>
                    <th class="text-right">Harga Jual</th>
                    <th class="text-right">Stok</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($produk as $item)
                    <tr>
                        <td>
                            <div class="font-medium text-[var(--ruto-text)]">{{ $item->nama_produk }}</div>
                            @if($item->tipe === 'jual' && $item->cup)
                                <div class="text-xs text-gray-400">Gelas: {{ $item->cup->nama_produk }}</div>
                            @endif
                        </td>
                        <td>{{ $item->kategori->nama_kategori }}</td>
                        <td>
                            @if ($item->tipe === 'jual')
                                <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Jual</span>
                            @else
                                <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">Baku</span>
                            @endif
                        </td>
                        <td class="text-right">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                        <td class="text-right">
                            @if ($item->stok < 10)
                                <span class="ruto-badge ruto-badge-danger">{{ $item->stok }}</span>
                            @else
                                {{ $item->stok }}
                            @endif
                        </td>
                        <td>
                            <span class="ruto-badge {{ $item->status === 'aktif' ? 'ruto-badge-success' : 'ruto-badge-muted' }}">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="space-x-2">
                            <a href="{{ route('produk.edit', $item) }}" class="ruto-link">Edit</a>
                            <form action="{{ route('produk.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Hapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ruto-link-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="ruto-empty">Belum ada produk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
