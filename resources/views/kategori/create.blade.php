<h1>Tambah Kategori</h1>

<form action="/kategori" method="POST">

    @csrf

    <input type="text" name="nama_kategori">

    <button type="submit">
        Simpan
    </button>

</form>