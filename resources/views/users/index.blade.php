@extends('layouts.app')

@section('title', 'Petugas')

@section('content')
    @include('partials.page-header', [
        'title' => 'Petugas',
        'subtitle' => 'Akun yang dapat masuk ke sistem peminjaman.',
        'crumbs' => [['Petugas', null]],
    ])

    <div class="card card-body border-0 shadow">
        <div class="table-wrapper">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th class="d-none d-md-table-cell">Email</th>
                        <th class="d-none d-sm-table-cell">Terdaftar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>
                                <div class="app-cell-main">
                                    @include('partials.avatar', ['name' => $user->name, 'size' => 36])
                                    <span>
                                        <span class="title d-block">
                                            {{ $user->name }}
                                            @if ($user->is(auth()->user()))
                                                <span class="app-badge app-badge--info ms-1">Anda</span>
                                            @endif
                                        </span>
                                        <span class="sub d-md-none">{{ $user->email }}</span>
                                    </span>
                                </div>
                            </td>
                            <td class="d-none d-md-table-cell">{{ $user->email }}</td>
                            <td class="d-none d-sm-table-cell small text-gray-600">{{ $user->created_at?->locale('id')->translatedFormat('j M Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @include('partials.list-footer', ['paginator' => $users])
    </div>
@endsection
