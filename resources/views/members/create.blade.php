@extends('layouts.app')

@section('title', 'Tambah member')

@section('content')
    @include('partials.page-header', [
        'title' => 'Tambah member',
        'subtitle' => 'Ambil foto lalu lengkapi data peminjam.',
        'crumbs' => [['Member', route('members.index')], ['Tambah', null]],
    ])

    <form action="{{ route('members.store') }}" method="post" novalidate>
        @csrf
        @include('members._form', ['member' => null])
    </form>
@endsection
