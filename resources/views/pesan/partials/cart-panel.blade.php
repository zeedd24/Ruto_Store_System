<div class="rc-cart-backdrop lg:hidden" x-show="cartOpen && tab === 'keranjang'" @click="cartOpen = false; tab = 'beranda'" x-transition.opacity></div>

<aside class="rc-cart-panel"
    :class="{ 'is-open': cartOpen, 'is-tab-active': tab === 'keranjang' }"
    role="region" aria-label="Keranjang">
    <div class="rc-cart-panel-header">
        <h2>Keranjang</h2>
        <button type="button" @click="cartOpen = false; if (window.innerWidth < 1024) tab = 'beranda'"
            class="rc-cart-close lg:hidden" aria-label="Tutup">&times;</button>
    </div>

    <div class="rc-cart-panel-body">
        <template x-if="cart.length === 0">
            <div class="rc-cart-empty">
                <span class="rc-cart-empty-icon">🛒</span>
                <p>Belum ada item</p>
                <button type="button" @click="pilihTab('beranda')" class="rc-btn rc-btn-secondary">Lihat Menu</button>
            </div>
        </template>

        <template x-for="(item, index) in cart" :key="item.produk_id">
            <div class="rc-cart-item">
                <div class="rc-cart-item-info">
                    <p class="rc-cart-item-name" x-text="item.nama_produk"></p>
                    <p class="rc-cart-item-price" x-text="formatRupiah(item.harga_jual)"></p>
                </div>
                <div class="rc-cart-item-qty">
                    <button type="button" @click="ubahQty(index, -1)" class="rc-qty-btn" aria-label="Kurangi">−</button>
                    <span x-text="item.qty"></span>
                    <button type="button" @click="ubahQty(index, 1)" class="rc-qty-btn" aria-label="Tambah">+</button>
                </div>
            </div>
        </template>
    </div>

    <div class="rc-cart-panel-footer" x-show="cart.length > 0">
        <div class="rc-cart-total">
            <span>Total</span>
            <strong x-text="formatRupiah(total)"></strong>
        </div>
        <div class="rc-input-group">
            <label class="rc-label">Catatan (opsional)</label>
            <textarea x-model="catatan" class="rc-textarea" rows="2" placeholder="Less sugar, no ice..."></textarea>
        </div>
        <p class="rc-cart-hint">Bayar di kasir setelah pesanan dikirim</p>
        <form method="POST" action="{{ route('pesan.store') }}" @submit="prepareSubmit">
            @csrf
            <div id="pesan-form-fields"></div>
            <button type="submit" class="rc-btn rc-btn-primary rc-btn-block">
                Kirim Pesanan
            </button>
        </form>
    </div>
</aside>
