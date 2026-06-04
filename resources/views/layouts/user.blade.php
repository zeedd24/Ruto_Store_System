<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#f8ecd8">
    <title>@yield('title', 'Pesan') — RUTO CAFFEE</title>
    <script>
        (function () {
            try {
                var t = localStorage.getItem('ruto-admin-theme');
                var dark = t === 'dark' || (!t && window.matchMedia('(prefers-color-scheme: dark)').matches);
                document.documentElement.setAttribute('data-theme', dark ? 'dark' : 'light');
                var tc = document.querySelector('meta[name="theme-color"]');
                if (tc) tc.content = dark ? '#080706' : '#f8ecd8';
            } catch (e) {}
        })();
    </script>
    @vite(['resources/css/app.css', 'resources/css/ruto-admin.css', 'resources/css/ruto-user.css', 'resources/js/app.js', 'resources/js/ruto-admin.js'])
    @stack('styles')
</head>
<body class="rc-body">
    <div class="rc-shell">
        <header class="rc-hero">
            <div class="rc-hero-bg" aria-hidden="true"></div>
            <div class="rc-hero-inner">
                <a href="{{ route('pesan.index') }}" class="rc-hero-brand">
                    <div class="rc-hero-logo-ring">
                        <x-ruto-logo class="rc-hero-logo" alt="RUTO CAFFEE" />
                    </div>
                    <div class="rc-hero-text">
                        <h1 class="rc-hero-title">RUTO <span class="rc-hero-accent">CAFFEE</span></h1>
                        <p class="rc-hero-tagline">Pesan Online · Fresh &amp; Hangat</p>
                    </div>
                </a>
                <button type="button" id="ruto-theme-toggle" class="ruto-theme-toggle rc-hero-theme" aria-label="Ganti tema">
                    <span class="ruto-theme-track" aria-hidden="true"><span class="ruto-theme-thumb"></span></span>
                    <span class="ruto-theme-icon ruto-theme-icon--sun" aria-hidden="true">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </span>
                    <span class="ruto-theme-icon ruto-theme-icon--moon" aria-hidden="true">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    </span>
                </button>
            </div>
        </header>

        <main class="rc-main">
            @if (session('success'))
                <div class="rc-alert rc-alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="rc-alert rc-alert-error">{{ session('error') }}</div>
            @endif
            @yield('content')
        </main>
    </div>
    @stack('scripts')
</body>
</html>
