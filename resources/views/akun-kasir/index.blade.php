@extends('layouts.admin')

@section('title', 'Akun Kasir')

@section('content')
<div class="flex justify-between items-center mb-4">
    <p class="text-gray-600">Kelola akun kasir — tambah, reset password, nonaktifkan, atau hapus</p>
    <a href="{{ route('akun-kasir.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">+ Tambah Kasir</a>
</div>

<div class="bg-amber-50 border border-amber-200 text-amber-900 text-sm rounded-lg p-4 mb-4">
    <strong>Catatan:</strong> Kasir yang sudah punya riwayat transaksi tidak bisa dihapus — nonaktifkan saja agar laporan tetap aman.
</div>

<div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="min-w-full text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left">Nama</th>
                <th class="px-4 py-3 text-left">Email</th>
                <th class="px-4 py-3 text-left">Status</th>
                <th class="px-4 py-3 text-right">Transaksi</th>
                <th class="px-4 py-3 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($kasir as $item)
                <tr class="border-t">
                    <td class="px-4 py-3 font-medium">{{ $item->name }}</td>
                    <td class="px-4 py-3">{{ $item->email }}</td>
                    <td class="px-4 py-3">
                        @if ($item->aktif)
                            <span class="px-2 py-0.5 rounded text-xs bg-green-100 text-green-800">Aktif</span>
                        @else
                            <span class="px-2 py-0.5 rounded text-xs bg-gray-200 text-gray-700">Nonaktif</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right">{{ $item->transaksi_count }}</td>
                    <td class="px-4 py-3 space-x-2 whitespace-nowrap">
                        <a href="{{ route('akun-kasir.edit', $item) }}" class="text-indigo-600 hover:underline">Edit</a>
                        <a href="{{ route('akun-kasir.reset-password', $item) }}" class="text-amber-700 hover:underline">Reset PW</a>
                        @if ($item->transaksi_count === 0)
                            <form action="{{ route('akun-kasir.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Hapus akun {{ $item->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-gray-500">Belum ada akun kasir.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
