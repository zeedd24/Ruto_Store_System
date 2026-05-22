@extends('layouts.admin')

@section('title', 'Tambah Akun Kasir')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-lg">
    <form action="{{ route('akun-kasir.store') }}" method="POST">
        @csrf
        @include('akun-kasir._form', ['kasir' => null, 'showPassword' => true, 'showAktif' => false])
        <div class="flex gap-2 mt-4">
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Simpan</button>
            <a href="{{ route('akun-kasir.index') }}" class="px-4 py-2 border rounded text-gray-600">Batal</a>
        </div>
    </form>
</div>
@endsection
