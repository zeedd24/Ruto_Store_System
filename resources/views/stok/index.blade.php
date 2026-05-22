@extends('layouts.admin')

@section('title', 'Stok')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="font-semibold mb-4">Tambah Stok Masuk</h3>
        <form action="{{ route('stok.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Produk</label>
                <select name="produk_id" class="w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="">Pilih produk</option>
                    @foreach ($produk as $item)
                        <option value="{{ $item->id }}" @selected(old('produk_id') == $item->id)>
                            {{ $item->nama_produk }} (stok: {{ $item->stok }})
                        </option>
                    @endforeach
                </select>
                @error('produk_id')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                <input type="number" name="jumlah" value="{{ old('jumlah') }}" min="1" class="w-full border-gray-300 rounded-md shadow-sm" required>
                @error('jumlah')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', today()->format('Y-m-d')) }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                @error('tanggal')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                <textarea name="keterangan" rows="2" class="w-full border-gray-300 rounded-md shadow-sm">{{ old('keterangan') }}</textarea>
            </div>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Simpan Stok</button>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="font-semibold mb-4">Stok Produk Saat Ini</h3>
        <div class="max-h-96 overflow-y-auto">
            @foreach ($produk as $item)
                <div class="flex justify-between py-2 border-b text-sm">
                    <span>{{ $item->nama_produk }}</span>
                    <span class="{{ $item->stok < 10 ? 'text-red-600 font-medium' : '' }}">{{ $item->stok }} unit</span>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow mt-6 overflow-hidden">
    <div class="px-4 py-3 border-b font-semibold">Riwayat Stok Masuk Terbaru</div>
    <table class="min-w-full text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-2 text-left">Tanggal</th>
                <th class="px-4 py-2 text-left">Produk</th>
                <th class="px-4 py-2 text-right">Jumlah</th>
                <th class="px-4 py-2 text-left">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($riwayat as $row)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $row->tanggal->format('d/m/Y') }}</td>
                    <td class="px-4 py-2">{{ $row->produk->nama_produk }}</td>
                    <td class="px-4 py-2 text-right">+{{ $row->jumlah }}</td>
                    <td class="px-4 py-2">{{ $row->keterangan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-4 py-4 text-center text-gray-500">Belum ada riwayat stok masuk.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
