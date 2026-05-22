@extends('layouts.kasir')

@section('title', 'POS')

@section('content')
<div x-data="posApp()" class="grid grid-cols-1 xl:grid-cols-3 gap-4">
    <div class="xl:col-span-2 space-y-4">
        <div class="bg-white rounded-lg shadow p-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Cari Produk</label>
            <input type="text" x-model="search" @input.debounce.300ms="cariProduk()"
                placeholder="Ketik nama produk atau kategori..."
                class="w-full border-gray-300 rounded-md shadow-sm">
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <h3 class="font-semibold mb-3">Daftar Produk</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3 max-h-[28rem] overflow-y-auto">
                <template x-for="item in produkList" :key="item.id">
                    <button type="button" @click="tambahKeKeranjang(item)"
                        class="text-left border rounded-lg p-3 hover:border-emerald-500 hover:bg-emerald-50 transition">
                        <p class="font-medium text-sm" x-text="item.nama_produk"></p>
                        <p class="text-xs text-gray-500" x-text="item.kategori?.nama_kategori"></p>
                        <p class="text-sm text-emerald-700 font-semibold mt-1" x-text="formatRupiah(item.harga_jual)"></p>
                        <p class="text-xs text-gray-400">Stok: <span x-text="item.stok"></span></p>
                    </button>
                </template>
            </div>
            <p x-show="produkList.length === 0" class="text-gray-500 text-sm text-center py-4">Produk tidak ditemukan.</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-4 flex flex-col">
        <h3 class="font-semibold mb-3">Keranjang</h3>

        <div class="flex-1 overflow-y-auto mb-4">
            <template x-for="(item, index) in cart" :key="item.produk_id">
                <div class="flex items-center justify-between py-2 border-b text-sm gap-2">
                    <div class="flex-1 min-w-0">
                        <p class="font-medium truncate" x-text="item.nama_produk"></p>
                        <p class="text-gray-500" x-text="formatRupiah(item.harga_jual)"></p>
                    </div>
                    <div class="flex items-center gap-1">
                        <button type="button" @click="ubahQty(index, -1)" class="w-7 h-7 border rounded">-</button>
                        <span class="w-6 text-center" x-text="item.qty"></span>
                        <button type="button" @click="ubahQty(index, 1)" class="w-7 h-7 border rounded">+</button>
                    </div>
                    <button type="button" @click="hapusItem(index)" class="text-red-500 text-xs">Hapus</button>
                </div>
            </template>
            <p x-show="cart.length === 0" class="text-gray-500 text-sm text-center py-6">Keranjang kosong.</p>
        </div>

        <div class="border-t pt-3 space-y-2">
            <div class="flex justify-between font-semibold text-lg">
                <span>Total</span>
                <span x-text="formatRupiah(total)"></span>
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Bayar</label>
                <input type="number" x-model.number="bayar" min="0" class="w-full border-gray-300 rounded-md shadow-sm">
            </div>
            <div class="flex justify-between text-sm">
                <span>Kembalian</span>
                <span class="font-medium" x-text="formatRupiah(Math.max(0, bayar - total))"></span>
            </div>

            <form method="POST" action="{{ route('kasir.checkout') }}" @submit="prepareSubmit">
                @csrf
                <div id="checkout-items"></div>
                <button type="submit" :disabled="cart.length === 0 || bayar < total"
                    class="w-full mt-2 bg-emerald-600 text-white py-3 rounded-lg font-semibold hover:bg-emerald-700 disabled:opacity-50 disabled:cursor-not-allowed">
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
