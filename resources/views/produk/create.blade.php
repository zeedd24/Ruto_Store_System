@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-xl">
    @include('produk._form', ['produk' => null])
</div>
@endsection
