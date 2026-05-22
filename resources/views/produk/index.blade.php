@extends('layouts.admin')

@section('title', 'Produk')

@section('content')
<div class="flex justify-between items-center mb-4">
    <p class="text-gray-600">Kelola data produk</p>
    <a href="{{ route('produk.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">+ Tambah Produk</a>
</div>

<div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="min-w-full text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left">Nama</th>
                <th class="px-4 py-3 text-left">Kategori</th>
                <th class="px-4 py-3 text-right">Harga Jual</th>
                <th class="px-4 py-3 text-right">Stok</th>
                <th class="px-4 py-3 text-left">Status</th>
                <th class="px-4 py-3 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($produk as $item)
                <tr class="border-t">
                    <td class="px-4 py-3">{{ $item->nama_produk }}</td>
                    <td class="px-4 py-3">{{ $item->kategori->nama_kategori }}</td>
                    <td class="px-4 py-3 text-right">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 text-right {{ $item->stok < 10 ? 'text-red-600 font-medium' : '' }}">{{ $item->stok }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-0.5 rounded text-xs {{ $item->status === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td class="px-4 py-3 space-x-2">
                        <a href="{{ route('produk.edit', $item) }}" class="text-indigo-600 hover:underline">Edit</a>
                        <form action="{{ route('produk.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Hapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">Belum ada produk.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
