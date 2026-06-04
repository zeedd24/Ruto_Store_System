@php
    $pendingPesanan = \App\Models\Pesanan::menungguBayar()->count();
    $tabPesanan = request()->routeIs('kasir.pesanan.*') || session('kasir_tab') === 'pesanan';
@endphp

<nav class="ruto-kasir-tabs" aria-label="Mode kasir">
    <a href="{{ route('kasir.index') }}"
       class="ruto-kasir-tab{{ !$tabPesanan ? ' is-active' : '' }}">
        Kasir Langsung
    </a>
    <a href="{{ route('kasir.pesanan.index') }}"
       class="ruto-kasir-tab{{ $tabPesanan ? ' is-active' : '' }}">
        Pesanan User
        @if ($pendingPesanan > 0)
            <span class="ruto-kasir-tab-badge">{{ $pendingPesanan }}</span>
        @endif
    </a>
</nav>
