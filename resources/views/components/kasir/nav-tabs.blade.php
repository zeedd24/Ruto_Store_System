@php
    $pendingPesanan = \App\Models\Pesanan::menungguBayar()->count();
    $tabPesanan = request()->routeIs('kasir.pesanan.*') || session('kasir_tab') === 'pesanan';
    $tabLaporanStok = request()->routeIs('kasir.laporan-stok.*');
@endphp

<nav class="ruto-kasir-tabs" aria-label="Mode kasir">
    <a href="{{ route('kasir.index') }}"
       class="ruto-kasir-tab{{ !$tabPesanan && !$tabLaporanStok ? ' is-active' : '' }}">
        Kasir Langsung
    </a>
    <a href="{{ route('kasir.pesanan.index') }}"
       class="ruto-kasir-tab{{ $tabPesanan ? ' is-active' : '' }}">
        Pesanan User
        @if ($pendingPesanan > 0)
            <span class="ruto-kasir-tab-badge">{{ $pendingPesanan }}</span>
        @endif
    </a>
    <a href="{{ route('kasir.laporan-stok.index') }}"
       class="ruto-kasir-tab{{ $tabLaporanStok ? ' is-active' : '' }}">
        Lapor Stok Bahan
    </a>
</nav>
