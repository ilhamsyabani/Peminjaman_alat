@extends('layouts.app')

@section('title', 'Tulis informasi')

@section('content')
    @include('partials.page-header', [
        'title' => 'Tulis informasi',
        'subtitle' => 'Informasi akan langsung tampil di halaman publik.',
        'crumbs' => [['Informasi', route('post.index')], ['Tulis', null]],
    ])

    <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data" novalidate>
        @csrf
        @include('post._form', ['post' => null])
    </form>
@endsection
