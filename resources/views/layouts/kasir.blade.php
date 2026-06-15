<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Kasir') — RUTO</title>
    <script>
        (function () {
            try {
                var t = localStorage.getItem('ruto-admin-theme');
                if (t === 'dark' || (!t && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.setAttribute('data-theme', 'dark');
                }
            } catch (e) {}
        })();
    </script>
    @vite(['resources/css/app.css', 'resources/css/ruto-admin.css', 'resources/css/ruto-kasir.css', 'resources/js/app.js', 'resources/js/ruto-admin.js'])
    @stack('styles')
</head>
<body class="ruto-admin-body ruto-kasir-body">
    <div class="ruto-kasir-shell">
        <header class="ruto-kasir-header">
            <a href="{{ route('kasir.index') }}" class="ruto-kasir-brand" title="Kasir POS">
                <div class="ruto-kasir-logo-wrap">
                    <x-ruto-logo class="ruto-kasir-logo" alt="RUTO" />
                </div>
                <span class="ruto-kasir-user">{{ auth()->user()->name }}</span>
            </a>

            <div class="ruto-kasir-header-actions">
                <span class="ruto-topbar-date">{{ \App\Support\RutoDate::formatDisplay() }}</span>
                <button
                    type="button"
                    id="ruto-theme-toggle"
                    class="ruto-theme-toggle"
                    aria-pressed="false"
                    aria-label="Ganti tema tampilan"
                >
                    <span class="ruto-theme-track" aria-hidden="true">
                        <span class="ruto-theme-thumb"></span>
                    </span>
                    <span class="ruto-theme-icon ruto-theme-icon--sun" aria-hidden="true">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </span>
                    <span class="ruto-theme-icon ruto-theme-icon--moon" aria-hidden="true">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    </span>
                </button>
                <a href="{{ route('profile.edit') }}" class="ruto-btn-secondary" style="font-size:0.8rem;padding:0.5rem 0.9rem;text-decoration:none;display:inline-flex;align-items:center;height:35px;box-sizing:border-box;">Profil</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="ruto-btn-secondary ruto-kasir-logout">Keluar</button>
                </form>
            </div>
        </header>

        <main class="ruto-kasir-main">
            @if (session('success'))
                <div class="ruto-alert ruto-alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="ruto-alert ruto-alert-error">{{ session('error') }}</div>
            @endif
            @yield('content')
        </main>
    </div>
    @stack('scripts')
</body>
</html>
