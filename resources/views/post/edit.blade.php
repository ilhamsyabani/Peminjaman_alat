@extends('layouts.app')

@section('title', 'Ubah informasi')

@section('content')
    @include('partials.page-header', [
        'title' => 'Ubah informasi',
        'subtitle' => $post->title,
        'crumbs' => [['Informasi', route('post.index')], ['Ubah', null]],
        'action' => [route('blog.post', $post), 'Lihat di situs', 'fa-external-link-alt'],
    ])

    <form action="{{ route('post.update', $post) }}" method="post" enctype="multipart/form-data" novalidate>
        @method('PUT')
        @csrf
        @include('post._form', ['post' => $post])
    </form>
@endsection
