@extends('layouts.app')

@section('title', 'Ubah ' . $member->name)

@section('content')
    @include('partials.page-header', [
        'title' => 'Ubah member',
        'subtitle' => $member->name,
        'crumbs' => [['Member', route('members.index')], [$member->name, route('members.show', $member)], ['Ubah', null]],
    ])

    <form action="{{ route('members.update', $member) }}" method="post" novalidate>
        @csrf
        @method('PUT')
        @include('members._form', ['member' => $member])
    </form>
@endsection
