<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') — RUTO</title>
    @vite(['resources/css/app.css', 'resources/css/ruto-auth.css', 'resources/js/app.js'])
</head>
<body class="ruto-auth-body ruto-auth-minimal">
    <div class="ruto-auth-minimal-wrap">
        <a href="{{ route('login') }}" class="ruto-auth-minimal-logo">
            <x-ruto-logo class="ruto-minimal-logo" />
        </a>
        <div class="ruto-auth-minimal-card">
            @yield('content')
        </div>
        <a href="{{ route('login') }}" class="ruto-auth-minimal-back">← Kembali ke login</a>
    </div>
</body>
</html>
