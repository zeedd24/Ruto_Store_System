@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-xl">
    @include('produk._form', ['produk' => $produk])
</div>
@endsection
