@extends('layouts.app')

@section('title', 'Tambah barang')

@section('content')
    @include('partials.page-header', [
        'title' => 'Tambah barang',
        'subtitle' => 'Lengkapi data barang dan lokasi penyimpanannya.',
        'crumbs' => [['Barang', route('products.index')], ['Tambah', null]],
    ])

    <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data" novalidate>
        @csrf
        @include('products._form', ['product' => null])
    </form>
@endsection
