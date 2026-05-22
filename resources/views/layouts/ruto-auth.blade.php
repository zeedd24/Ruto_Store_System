<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Masuk') — RUTO</title>
    @vite(['resources/css/app.css', 'resources/css/ruto-auth.css', 'resources/js/app.js'])
</head>
<body class="ruto-auth-body">
    <div class="ruto-auth-grid">
        <aside class="ruto-auth-brand">
            <div class="ruto-login-hero">
                <div class="ruto-login-logo-wrap">
                    <x-ruto-logo class="ruto-login-logo" />
                </div>
                <div class="ruto-login-steam" aria-hidden="true">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
            <p class="tagline">{{ config('ruto.tagline') }}</p>
            <p class="quote">"{{ config('ruto.quote') }}"</p>
        </aside>

        <section class="ruto-auth-form-panel">
            <div class="ruto-auth-card">
                @yield('content')
            </div>
        </section>
    </div>
</body>
</html>
