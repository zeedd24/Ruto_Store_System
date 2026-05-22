@extends('layouts.admin')

@section('title', 'Kategori')

@section('content')
<div class="flex justify-between items-center mb-4">
    <p class="text-gray-600">Kelola kategori produk</p>
    <a href="{{ route('kategori.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">+ Tambah Kategori</a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left">No</th>
                <th class="px-4 py-3 text-left">Nama Kategori</th>
                <th class="px-4 py-3 text-left">Jumlah Produk</th>
                <th class="px-4 py-3 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($kategori as $index => $item)
                <tr class="border-t">
                    <td class="px-4 py-3">{{ $index + 1 }}</td>
                    <td class="px-4 py-3">{{ $item->nama_kategori }}</td>
                    <td class="px-4 py-3">{{ $item->produk_count }}</td>
                    <td class="px-4 py-3 space-x-2">
                        <a href="{{ route('kategori.edit', $item) }}" class="text-indigo-600 hover:underline">Edit</a>
                        <form action="{{ route('kategori.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-4 py-6 text-center text-gray-500">Belum ada kategori.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
