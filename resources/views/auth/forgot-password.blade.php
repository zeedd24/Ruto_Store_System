@extends('layouts.ruto-auth-simple')

@section('title', 'Lupa Password')

@section('content')
<h3>Reset dengan Kunci Pemulihan</h3>
<p class="subtitle" style="margin-bottom: 1.5rem;">
    Masukkan email akun, kunci pemulihan dari file .env, dan password baru Anda.
</p>

@if (session('status'))
    <div class="ruto-status-success">{{ session('status') }}</div>
@endif

<form method="POST" action="{{ route('password.reset_with_key') }}">
    @csrf

    <div class="ruto-field">
        <label for="email">Email Akun</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="admin@ruto.store">
        @error('email')
            <p class="ruto-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="ruto-field">
        <label for="recovery_key">Kunci Pemulihan (Recovery Key)</label>
        <input id="recovery_key" type="password" name="recovery_key" required placeholder="Masukkan kunci dari .env">
        @error('recovery_key')
            <p class="ruto-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="ruto-field">
        <label for="password">Password Baru</label>
        <input id="password" type="password" name="password" required placeholder="Minimal 8 karakter">
        @error('password')
            <p class="ruto-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="ruto-field">
        <label for="password_confirmation">Konfirmasi Password Baru</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="Ulangi password baru">
    </div>

    <button type="submit" class="ruto-btn-primary" style="width: 100%; margin-top: 1rem;">Reset Password</button>
</form>

<div style="margin-top: 1.5rem; text-align: center; font-size: 0.85rem;">
    <a href="{{ route('login') }}" class="ruto-link" style="color: var(--ruto-brand-dark); text-decoration: none; font-weight: 500;">← Kembali ke Halaman Login</a>
</div>
@endsection
