@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-lg">
    <form action="{{ route('kategori.update', $kategori) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
            <input type="text" name="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
            @error('nama_kategori')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="flex gap-2">
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Update</button>
            <a href="{{ route('kategori.index') }}" class="px-4 py-2 border rounded text-gray-600">Batal</a>
        </div>
    </form>
</div>
@endsection
