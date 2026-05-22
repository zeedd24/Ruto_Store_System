@extends('layouts.admin')

@section('title', 'Reset Password Kasir')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-lg">
    <p class="text-gray-600 mb-4">
        Reset password untuk <strong>{{ $kasir->name }}</strong> ({{ $kasir->email }}).
    </p>

    <form action="{{ route('akun-kasir.reset-password.update', $kasir) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
            <input type="password" name="password" class="w-full border-gray-300 rounded-md shadow-sm" required>
            @error('password')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="w-full border-gray-300 rounded-md shadow-sm" required>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-amber-600 text-white px-4 py-2 rounded hover:bg-amber-700">Reset Password</button>
            <a href="{{ route('akun-kasir.index') }}" class="px-4 py-2 border rounded text-gray-600">Batal</a>
        </div>
    </form>
</div>
@endsection
