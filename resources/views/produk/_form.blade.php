<form action="{{ $produk ? route('produk.update', $produk) : route('produk.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if ($produk) @method('PUT') @endif

    <div class="ruto-field">
        <label>Kategori</label>
        <select name="kategori_id" class="ruto-select" required>
            <option value="">Pilih kategori</option>
            @foreach ($kategori as $kat)
                <option value="{{ $kat->id }}" @selected(old('kategori_id', $produk?->kategori_id) == $kat->id)>{{ $kat->nama_kategori }}</option>
            @endforeach
        </select>
        @error('kategori_id')<p class="ruto-field-error">{{ $message }}</p>@enderror
    </div>

    <div class="ruto-field">
        <label>Nama Produk</label>
        <input type="text" name="nama_produk" value="{{ old('nama_produk', $produk?->nama_produk) }}" class="ruto-input" required>
        @error('nama_produk')<p class="ruto-field-error">{{ $message }}</p>@enderror
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="ruto-field">
            <label>Tipe Produk</label>
            <select name="tipe" id="tipe-select" class="ruto-select" required onchange="toggleCupSelect()">
                <option value="jual" @selected(old('tipe', $produk?->tipe ?? 'jual') === 'jual')>Produk Jual</option>
                <option value="baku" @selected(old('tipe', $produk?->tipe) === 'baku')>Produk Baku</option>
            </select>
            @error('tipe')<p class="ruto-field-error">{{ $message }}</p>@enderror
        </div>
        <div class="ruto-field" id="cup-field">
            <label>Hubungkan Cup (Khusus Minuman)</label>
            <select name="cup_id" class="ruto-select">
                <option value="">Tidak Menggunakan Cup</option>
                @foreach ($cups as $cup)
                    <option value="{{ $cup->id }}" @selected(old('cup_id', $produk?->cup_id) == $cup->id)>{{ $cup->nama_produk }} (Stok: {{ $cup->stok }})</option>
                @endforeach
            </select>
            @error('cup_id')<p class="ruto-field-error">{{ $message }}</p>@enderror
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="ruto-field">
            <label>Harga Modal</label>
            <input type="number" name="harga_modal" value="{{ old('harga_modal', $produk?->harga_modal) }}" min="0" step="0.01" class="ruto-input" required>
            @error('harga_modal')<p class="ruto-field-error">{{ $message }}</p>@enderror
        </div>
        <div class="ruto-field">
            <label>Harga Jual</label>
            <input type="number" name="harga_jual" value="{{ old('harga_jual', $produk?->harga_jual) }}" min="0" step="0.01" class="ruto-input" required>
            @error('harga_jual')<p class="ruto-field-error">{{ $message }}</p>@enderror
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="ruto-field">
            <label>Stok</label>
            <input type="number" name="stok" value="{{ old('stok', $produk?->stok ?? 0) }}" min="0" class="ruto-input" required>
            @error('stok')<p class="ruto-field-error">{{ $message }}</p>@enderror
        </div>
        <div class="ruto-field">
            <label>Status</label>
            <select name="status" class="ruto-select" required>
                <option value="aktif" @selected(old('status', $produk?->status ?? 'aktif') === 'aktif')>Aktif</option>
                <option value="nonaktif" @selected(old('status', $produk?->status) === 'nonaktif')>Nonaktif</option>
            </select>
            @error('status')<p class="ruto-field-error">{{ $message }}</p>@enderror
        </div>
    </div>

    <div class="ruto-field">
        <label>Gambar Produk</label>
        @if ($produk?->gambar_url)
            <div class="mb-2">
                <img src="{{ $produk->gambar_url }}" alt="Gambar {{ $produk->nama_produk }}" class="h-20 w-20 rounded object-cover border">
            </div>
        @endif
        <input type="file" name="gambar" accept="image/*" class="ruto-input">
        <p class="text-xs text-gray-500 mt-1">Opsional. JPG/PNG/WEBP maksimal 2MB.</p>
        @error('gambar')<p class="ruto-field-error">{{ $message }}</p>@enderror
    </div>
    <x-admin.form-actions :cancel="route('produk.index')" />
</form>

<script>
    function toggleCupSelect() {
        const tipeSelect = document.getElementById('tipe-select');
        const cupField = document.getElementById('cup-field');
        if (tipeSelect && cupField) {
            if (tipeSelect.value === 'baku') {
                cupField.style.display = 'none';
                cupField.querySelector('select').value = '';
            } else {
                cupField.style.display = 'block';
            }
        }
    }
    // Run immediately and after load
    toggleCupSelect();
    window.addEventListener('load', toggleCupSelect);
</script>
