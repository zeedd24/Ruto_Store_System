<form action="{{ $produk ? route('produk.update', $produk) : route('produk.store') }}" method="POST">
    @csrf
    @if ($produk) @method('PUT') @endif

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
        <select name="kategori_id" class="w-full border-gray-300 rounded-md shadow-sm" required>
            <option value="">Pilih kategori</option>
            @foreach ($kategori as $kat)
                <option value="{{ $kat->id }}" @selected(old('kategori_id', $produk?->kategori_id) == $kat->id)>{{ $kat->nama_kategori }}</option>
            @endforeach
        </select>
        @error('kategori_id')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
        <input type="text" name="nama_produk" value="{{ old('nama_produk', $produk?->nama_produk) }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
        @error('nama_produk')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
    </div>

    <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Harga Modal</label>
            <input type="number" name="harga_modal" value="{{ old('harga_modal', $produk?->harga_modal) }}" min="0" step="0.01" class="w-full border-gray-300 rounded-md shadow-sm" required>
            @error('harga_modal')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Harga Jual</label>
            <input type="number" name="harga_jual" value="{{ old('harga_jual', $produk?->harga_jual) }}" min="0" step="0.01" class="w-full border-gray-300 rounded-md shadow-sm" required>
            @error('harga_jual')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
            <input type="number" name="stok" value="{{ old('stok', $produk?->stok ?? 0) }}" min="0" class="w-full border-gray-300 rounded-md shadow-sm" required>
            @error('stok')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="status" class="w-full border-gray-300 rounded-md shadow-sm" required>
                <option value="aktif" @selected(old('status', $produk?->status ?? 'aktif') === 'aktif')>Aktif</option>
                <option value="nonaktif" @selected(old('status', $produk?->status) === 'nonaktif')>Nonaktif</option>
            </select>
            @error('status')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
    </div>

    <div class="flex gap-2">
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Simpan</button>
        <a href="{{ route('produk.index') }}" class="px-4 py-2 border rounded text-gray-600">Batal</a>
    </div>
</form>
