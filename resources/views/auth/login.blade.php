@extends('layouts.ruto-auth')

@section('title', 'Masuk')

@section('content')
<a href="{{ route('splash') }}" class="ruto-back-splash">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
    Kembali
</a>

<h3>Masuk ke Sistem</h3>
<p class="subtitle">Admin &amp; kasir — kelola operasional RUTO</p>

@if (session('status'))
    <div class="mb-4 p-3 rounded-lg bg-green-50 text-green-800 text-sm">{{ session('status') }}</div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="ruto-field">
        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="nama@ruto.store">
        @error('email')
            <p class="ruto-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="ruto-field mt-4">
        <label for="password">Password</label>
        <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
        @error('password')
            <p class="ruto-error">{{ $message }}</p>
        @enderror
    </div>

    <label class="ruto-remember">
        <input type="checkbox" name="remember" id="remember_me">
        Ingat saya
    </label>

    <button type="submit" class="ruto-btn-primary">Masuk</button>

    @if (Route::has('password.request'))
        <p class="ruto-auth-footer">
            <a href="{{ route('password.request') }}">Lupa password?</a>
        </p>
    @endif
</form>
@endsection
