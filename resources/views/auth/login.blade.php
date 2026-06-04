@extends('layouts.ruto-auth')

@section('title', 'Masuk')

@section('content')
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

    <a href="{{ route('pesan.index') }}" class="ruto-btn-secondary w-full justify-center mt-3" style="width:100%;justify-content:center;text-align:center;display:flex">
        Pesan Langsung
    </a>

    @if (Route::has('password.request'))
        <p class="ruto-auth-footer">
            <a href="{{ route('password.request') }}">Lupa password?</a>
        </p>
    @endif
</form>
@endsection
