@extends('layouts.admin')

@section('title', 'Edit Akun Kasir')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-lg">
    <form action="{{ route('akun-kasir.update', $kasir) }}" method="POST">
        @csrf
        @method('PUT')
        @include('akun-kasir._form', ['kasir' => $kasir, 'showPassword' => false, 'showAktif' => true])
        <div class="flex gap-2 mt-4">
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Update</button>
            <a href="{{ route('akun-kasir.index') }}" class="px-4 py-2 border rounded text-gray-600">Batal</a>
        </div>
    </form>
</div>
@endsection
