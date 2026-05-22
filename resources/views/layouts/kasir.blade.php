<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Kasir') - {{ config('app.name', 'Ruto Store') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <header class="bg-emerald-700 text-white px-6 py-3 flex justify-between items-center">
        <div>
            <h1 class="text-lg font-bold">Ruto Store — POS Kasir</h1>
            <p class="text-sm text-emerald-100">{{ auth()->user()->name }}</p>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm bg-emerald-800 hover:bg-emerald-900 px-3 py-1 rounded">Keluar</button>
        </form>
    </header>

    <main class="p-4">
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
        @endif
        @yield('content')
    </main>
</body>
</html>
