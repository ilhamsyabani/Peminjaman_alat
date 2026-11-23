@extends('layouts.app')

@section('title', 'Laporan member')

@section('content')
    @include('partials.page-header', ['title' => 'Laporan member', 'crumbs' => [['Laporan', null], ['Member', null]], 'subtitle' => 'Riwayat peminjaman per member.'])
    <div class="card card-body border-0 shadow">
        @include('partials.list-toolbar', ['placeholder' => 'Cari nama member'])

        <div class="table-wrapper">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Member</th>
                        <th class="d-none d-md-table-cell">Kontak</th>
                        <th class="d-none d-sm-table-cell">Total transaksi</th>
                        <th>Status</th>
                        <th class="text-end"><span class="visually-hidden">Aksi</span></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($members as $member)
                        <tr>
                            <td>
                                <div class="app-cell-main">
                                    @include('partials.avatar', ['name' => $member->name, 'photo' => $member->photo, 'size' => 36])
                                    <span>
                                        <span class="title d-block">{{ $member->name }}</span>
                                        <span class="sub">{{ $member->identity_number }}</span>
                                    </span>
                                </div>
                            </td>
                            <td class="d-none d-md-table-cell small">{{ $member->hp }}<br><span class="text-gray-500">{{ $member->email }}</span></td>
                            <td class="d-none d-sm-table-cell">{{ $member->transaction->count() }}</td>
                            <td>@include('partials.status', ['status' => $member->status, 'type' => 'member'])</td>
                            <td class="text-end">
                                <a class="btn btn-sm btn-outline-gray-600" href="{{ route('report.member-detail', $member) }}">Riwayat</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="app-empty">
                                <i class="fas fa-users" aria-hidden="true"></i>
                                {{ request('search') ? 'Tidak ada data yang cocok dengan pencarian.' : 'Belum ada member.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @include('partials.list-footer', ['paginator' => $members])
    </div>
@endsection
