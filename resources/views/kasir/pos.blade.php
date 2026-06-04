@extends('layouts.kasir')

@section('title', 'POS')

@section('content')
<x-kasir.nav-tabs />

<div x-data="posApp()" class="ruto-pos-layout mt-4">
    <div class="space-y-4">
        <div class="ruto-card ruto-card-padded">
            <div class="ruto-field">
                <label>Cari Produk</label>
                <input type="text" x-model="search" @input.debounce.300ms="cariProduk()"
                    placeholder="Ketik nama produk atau kategori..."
                    class="ruto-input">
            </div>
        </div>

        <div class="ruto-card ruto-card-padded">
            <h3 class="ruto-card-title">Daftar Produk</h3>
            <div class="ruto-pos-grid">
                <template x-for="item in produkList" :key="item.id">
                    <button type="button" @click="tambahKeKeranjang(item)" class="ruto-pos-product">
                        <div class="ruto-pos-product-img">
                            <template x-if="item.gambar_url">
                                <img :src="item.gambar_url"
                                     :alt="`Gambar ${item.nama_produk}`"
                                     loading="lazy"
                                     x-on:error="item.gambar_url = null">
                            </template>
                            <template x-if="!item.gambar_url">
                                <div class="ruto-pos-product-placeholder">Tidak ada gambar</div>
                            </template>
                        </div>
                        <div class="ruto-pos-product-body">
                            <p class="ruto-pos-product-name" x-text="item.nama_produk"></p>
                            <p class="ruto-pos-product-cat" x-text="item.kategori?.nama_kategori"></p>
                            <div class="ruto-pos-product-meta">
                                <span class="ruto-pos-product-price" x-text="formatRupiah(item.harga_jual)"></span>
                                <span class="ruto-pos-product-stok">Stok: <span x-text="item.stok"></span></span>
                            </div>
                        </div>
                    </button>
                </template>
            </div>
            <p x-show="produkList.length === 0" class="ruto-pos-empty">Produk tidak ditemukan.</p>
        </div>
    </div>

    <div class="ruto-card ruto-card-padded ruto-pos-cart">
        <h3 class="ruto-card-title">Keranjang</h3>

        <div class="ruto-pos-cart-list">
            <template x-for="(item, index) in cart" :key="item.produk_id">
                <div class="ruto-pos-cart-item">
                    <div class="flex-1 min-w-0">
                        <p class="ruto-pos-cart-item-name" x-text="item.nama_produk"></p>
                        <p class="ruto-pos-cart-item-price" x-text="formatRupiah(item.harga_jual)"></p>
                    </div>
                    <div class="flex items-center gap-1">
                        <button type="button" @click="ubahQty(index, -1)" class="ruto-pos-qty-btn">-</button>
                        <span class="w-6 text-center" style="color:var(--ruto-text)" x-text="item.qty"></span>
                        <button type="button" @click="ubahQty(index, 1)" class="ruto-pos-qty-btn">+</button>
                    </div>
                    <button type="button" @click="hapusItem(index)" class="ruto-pos-cart-remove">Hapus</button>
                </div>
            </template>
            <p x-show="cart.length === 0" class="ruto-pos-empty">Keranjang kosong.</p>
        </div>

        <div class="ruto-pos-checkout-footer">
            <div class="ruto-pos-total-row">
                <span>Total</span>
                <span x-text="formatRupiah(total)"></span>
            </div>
            <div class="ruto-field">
                <label>Bayar</label>
                <input type="number" x-model.number="bayar" min="0" class="ruto-input">
            </div>
            <div class="flex justify-between text-sm mb-3" style="color:var(--ruto-text-muted)">
                <span>Kembalian</span>
                <span class="font-medium" style="color:var(--ruto-brand-dark)" x-text="formatRupiah(Math.max(0, bayar - total))"></span>
            </div>

            <form method="POST" action="{{ route('kasir.checkout') }}" @submit="prepareSubmit">
                @csrf
                <div id="checkout-items"></div>
                <button type="submit" :disabled="cart.length === 0 || bayar < total"
                    class="ruto-btn-primary w-full justify-center"
                    style="width:100%;justify-content:center;padding:0.85rem 1rem;margin-top:0.5rem"
                    :style="(cart.length === 0 || bayar < total) ? 'opacity:0.5;cursor:not-allowed' : ''">
                    Checkout
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    const produkAwal = @json($produk);

    function posApp() {
        return {
            search: '',
            produkList: produkAwal,
            cart: [],
            bayar: 0,

            get total() {
                return this.cart.reduce((sum, item) => sum + (item.harga_jual * item.qty), 0);
            },

            formatRupiah(n) {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(n);
            },

            async cariProduk() {
                const res = await fetch(`{{ route('kasir.search') }}?q=${encodeURIComponent(this.search)}`);
                this.produkList = await res.json();
            },

            tambahKeKeranjang(produk) {
                const existing = this.cart.find(c => c.produk_id === produk.id);
                if (existing) {
                    if (existing.qty >= produk.stok) {
                        alert('Stok tidak mencukupi.');
                        return;
                    }
                    existing.qty++;
                } else {
                    this.cart.push({
                        produk_id: produk.id,
                        nama_produk: produk.nama_produk,
                        harga_jual: parseFloat(produk.harga_jual),
                        stok: produk.stok,
                        qty: 1
                    });
                }
            },

            ubahQty(index, delta) {
                const item = this.cart[index];
                const baru = item.qty + delta;
                if (baru <= 0) {
                    this.cart.splice(index, 1);
                } else if (baru > item.stok) {
                    alert('Stok tidak mencukupi.');
                } else {
                    item.qty = baru;
                }
            },

            hapusItem(index) {
                this.cart.splice(index, 1);
            },

            prepareSubmit(e) {
                if (this.cart.length === 0 || this.bayar < this.total) {
                    e.preventDefault();
                    return;
                }
                const container = document.getElementById('checkout-items');
                container.innerHTML = '';
                this.cart.forEach((item, i) => {
                    container.innerHTML += `<input type="hidden" name="items[${i}][produk_id]" value="${item.produk_id}">`;
                    container.innerHTML += `<input type="hidden" name="items[${i}][qty]" value="${item.qty}">`;
                });
                container.innerHTML += `<input type="hidden" name="bayar" value="${this.bayar}">`;
            }
        };
    }
</script>
@endsection
