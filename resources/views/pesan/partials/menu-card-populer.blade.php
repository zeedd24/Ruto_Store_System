<article class="rc-menu-card rc-menu-card--populer"
    :class="{ 'rc-menu-card--in-cart': qtyInCart(item.id) > 0, 'rc-menu-card--liked': isLiked(item.id) }"
    @click="tambahKeKeranjang(item)">
    <div class="rc-menu-card-img">
        <template x-if="item.gambar_url">
            <img :src="item.gambar_url" :alt="item.nama_produk" loading="lazy"
                 x-on:error="item.gambar_url = null">
        </template>
        <template x-if="!item.gambar_url">
            <div class="rc-menu-card-placeholder">☕</div>
        </template>
        <span class="rc-populer-badge">Populer</span>
        <span class="rc-menu-card-qty" x-show="qtyInCart(item.id) > 0" x-text="qtyInCart(item.id)"></span>
    </div>
    <div class="rc-menu-card-body rc-menu-card-body--compact">
        <h3 class="rc-menu-card-name" x-text="item.nama_produk"></h3>
        <span class="rc-menu-card-price" x-text="formatRupiah(item.harga_jual)"></span>
    </div>
</article>
