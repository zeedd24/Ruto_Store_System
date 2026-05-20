<h1>Data Kategori</h1>

<a href="/kategori/create">Tambah Kategori</a>

<hr>

@foreach ($kategori as $item)

    <p>{{ $item->nama_kategori }}</p>

@endforeach