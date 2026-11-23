@extends('layouts.app')

@section('title', $member->name)

@section('content')
    @include('partials.page-header', [
        'title' => $member->name,
        'crumbs' => [['Member', route('members.index')], [$member->name, null]],
    ])

    @php($riwayat = $member->transaction()->latest()->take(5)->get())

    <div class="row">
        <div class="col-12 col-xl-4 order-xl-2 mb-4">
            <div class="card border-0 shadow text-center">
                <div class="card-body py-5">
                    <div class="d-flex justify-content-center mb-3">
                        @include('partials.avatar', ['name' => $member->name, 'photo' => $member->photo, 'size' => 112])
                    </div>
                    <h2 class="h4 mb-2">{{ $member->name }}</h2>
                    <div class="mb-4">@include('partials.status', ['status' => $member->status, 'type' => 'member'])</div>

                    <div class="d-flex flex-wrap justify-content-center gap-2">
                        @if ($member->status === 'tidak_ada')
                            <form action="{{ route('processmember') }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="process">
                                <input type="hidden" name="id" value="{{ $member->id }}">
                                <button class="btn btn-gray-800 d-inline-flex align-items-center" type="submit">
                                    <i class="fas fa-plus me-2" aria-hidden="true"></i>Buat pinjaman
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('members.edit', $member) }}" class="btn btn-outline-gray-600 d-inline-flex align-items-center">
                            <i class="fas fa-pen me-2" aria-hidden="true"></i>Ubah data
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-8 order-xl-1">
            <div class="card border-0 shadow mb-4">
                <div class="card-body">
                    <h2 class="h5 mb-4">Data member</h2>
                    <dl class="app-dl">
                        <dt>Nomor identitas</dt>
                        <dd>{{ $member->identity_number }}</dd>
                        <dt>Email</dt>
                        <dd><a href="mailto:{{ $member->email }}">{{ $member->email }}</a></dd>
                        <dt>No. HP</dt>
                        <dd>{{ $member->hp }}</dd>
                        <dt>Alamat</dt>
                        <dd>{{ $member->address }}</dd>
                        <dt>Keterangan</dt>
                        <dd>{{ $member->info ?: '—' }}</dd>
                    </dl>
                </div>
            </div>

            <div class="card border-0 shadow mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="h5 mb-0">Riwayat peminjaman</h2>
                        <a href="{{ route('report.member-detail', $member) }}" class="small fw-bold">Lihat semua</a>
                    </div>
                    @forelse ($riwayat as $trx)
                        <a href="{{ route('transactions.view', $trx) }}" class="app-list-row">
                            <div>
                                <div class="fw-bold text-gray-900">Transaksi #{{ $trx->id }}</div>
                                <div class="small text-gray-500">
                                    {{ \Illuminate\Support\Carbon::parse($trx->transaction_date)->locale('id')->translatedFormat('j F Y') }}
                                    · {{ $trx->total }} barang · Jaminan {{ $trx->collateral }}
                                </div>
                            </div>
                            @include('partials.status', ['status' => $trx->status, 'type' => 'transaction'])
                        </a>
                    @empty
                        <p class="text-gray-500 mb-0">Belum pernah meminjam.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
