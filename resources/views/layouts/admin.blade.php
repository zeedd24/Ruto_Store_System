<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - {{ config('app.name', 'Ruto Store') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex">
        <aside class="w-64 bg-indigo-800 text-white flex-shrink-0 flex flex-col min-h-screen">
            <div class="p-4 border-b border-indigo-700">
                <h1 class="text-lg font-bold">Ruto Store</h1>
                <p class="text-xs text-indigo-200">Panel Admin</p>
            </div>
            <nav class="p-3 space-y-1 flex-1">
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded {{ request()->routeIs('dashboard') ? 'bg-indigo-700' : 'hover:bg-indigo-700' }}">Dashboard</a>
                <a href="{{ route('kategori.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('kategori.*') ? 'bg-indigo-700' : 'hover:bg-indigo-700' }}">Kategori</a>
                <a href="{{ route('produk.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('produk.*') ? 'bg-indigo-700' : 'hover:bg-indigo-700' }}">Produk</a>
                <a href="{{ route('stok.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('stok.*') ? 'bg-indigo-700' : 'hover:bg-indigo-700' }}">Stok</a>
                <a href="{{ route('laporan.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('laporan.*') ? 'bg-indigo-700' : 'hover:bg-indigo-700' }}">Laporan</a>
                <a href="{{ route('grafik.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('grafik.*') ? 'bg-indigo-700' : 'hover:bg-indigo-700' }}">Grafik</a>
                <a href="{{ route('akun-kasir.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('akun-kasir.*') ? 'bg-indigo-700' : 'hover:bg-indigo-700' }}">Akun Kasir</a>
            </nav>
            <div class="p-4 border-t border-indigo-700">
                <p class="text-sm truncate">{{ auth()->user()->name }}</p>
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="text-sm text-indigo-200 hover:text-white">Keluar</button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col">
            <header class="bg-white shadow px-6 py-4">
                <h2 class="text-xl font-semibold text-gray-800">@yield('title')</h2>
            </header>

            <main class="flex-1 p-6">
                @if (session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
