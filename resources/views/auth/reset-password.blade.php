@extends('layouts.ruto-auth-simple')

@section('title', 'Reset Password')

@section('content')
<h3>Password Baru</h3>
<p class="subtitle">Masukkan password baru untuk akun Anda.</p>

<form method="POST" action="{{ route('password.store') }}">
    @csrf

    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <div class="ruto-field">
        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
        @error('email')
            <p class="ruto-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="ruto-field mt-4">
        <label for="password">Password Baru</label>
        <input id="password" type="password" name="password" required autocomplete="new-password">
        @error('password')
            <p class="ruto-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="ruto-field mt-4">
        <label for="password_confirmation">Konfirmasi Password</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
        @error('password_confirmation')
            <p class="ruto-error">{{ $message }}</p>
        @enderror
    </div>

    <button type="submit" class="ruto-btn-primary">Simpan Password Baru</button>
</form>
@endsection
