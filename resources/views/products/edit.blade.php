@extends('layouts.app')

@section('title', 'Ubah ' . $product->name)

@section('content')
    @include('partials.page-header', [
        'title' => 'Ubah barang',
        'subtitle' => $product->code . ' · ' . $product->name,
        'crumbs' => [['Barang', route('products.index')], [$product->name, route('products.show', $product)], ['Ubah', null]],
    ])

    <form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data" novalidate>
        @method('PUT')
        @csrf
        @include('products._form', ['product' => $product])
    </form>
@endsection
