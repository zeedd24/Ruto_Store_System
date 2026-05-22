@extends('layouts.ruto-auth-simple')

@section('title', 'Lupa Password')

@section('content')
<h3>Lupa Password?</h3>
<p class="subtitle">
    Masukkan email akun Anda (admin atau kasir). Kami akan mengirim link untuk membuat password baru.
</p>

@if (session('status'))
    <div class="ruto-status-success">{{ session('status') }}</div>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <div class="ruto-field">
        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="admin@ruto.store">
        @error('email')
            <p class="ruto-error">{{ $message }}</p>
        @enderror
    </div>

    <button type="submit" class="ruto-btn-primary">Kirim Link Reset Password</button>
</form>
@endsection
