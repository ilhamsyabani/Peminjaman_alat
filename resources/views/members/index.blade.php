@extends('layouts.app')

@section('title', 'Member')

@section('content')
    @include('partials.page-header', ['title' => 'Member', 'crumbs' => [['Member', null]], 'subtitle' => 'Data peminjam yang terdaftar di LAP TP.', 'action' => [route('members.create'), 'Tambah member', 'fa-user-plus']])
    <div class="card card-body border-0 shadow">
        @include('partials.list-toolbar', ['placeholder' => 'Cari nama atau nomor identitas'])

        <div class="table-wrapper">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Member</th>
                        <th class="d-none d-md-table-cell">Kontak</th>
                        <th class="d-none d-lg-table-cell">Alamat</th>
                        <th>Status</th>
                        <th class="text-end"><span class="visually-hidden">Aksi</span></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($members as $member)
                        <tr>
                            <td>
                                <a href="{{ route('members.show', $member) }}" class="app-cell-main">
                                    @include('partials.avatar', ['name' => $member->name, 'photo' => $member->photo, 'size' => 44])
                                    <span>
                                        <span class="title d-block">{{ $member->name }}</span>
                                        <span class="sub">{{ $member->identity_number }}</span>
                                    </span>
                                </a>
                            </td>
                            <td class="d-none d-md-table-cell small">
                                {{ $member->hp }}<br>
                                <span class="text-gray-500">{{ $member->email }}</span>
                            </td>
                            <td class="d-none d-lg-table-cell small text-wrap" style="max-width: 240px">{{ $member->address }}</td>
                            <td>@include('partials.status', ['status' => $member->status, 'type' => 'member'])</td>
                            <td>
                                <div class="app-actions">
                                    <a class="app-icon-btn" href="{{ route('members.edit', $member) }}" title="Ubah" aria-label="Ubah {{ $member->name }}">
                                        <i class="fas fa-pen" aria-hidden="true"></i>
                                    </a>
                                    <form action="{{ route('members.destroy', $member) }}" method="post">
                                        @method('delete')
                                        @csrf
                                        <button class="app-icon-btn app-icon-btn--danger" title="Hapus" aria-label="Hapus {{ $member->name }}"
                                            onclick="return confirm('Hapus member {{ e(addslashes($member->name)) }}?')">
                                            <i class="fas fa-trash-alt" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="app-empty">
                                <i class="fas fa-users" aria-hidden="true"></i>
                                {{ request('search') ? 'Tidak ada member yang cocok dengan pencarian.' : 'Belum ada member terdaftar.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @include('partials.list-footer', ['paginator' => $members])
    </div>
@endsection
