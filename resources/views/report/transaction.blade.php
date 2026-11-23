@extends('layouts.app')

@section('title', 'Laporan transaksi')

@section('content')
    @include('partials.page-header', ['title' => 'Laporan transaksi', 'crumbs' => [['Laporan', null], ['Transaksi', null]], 'subtitle' => 'Riwayat seluruh transaksi peminjaman.'])
    <div class="card card-body border-0 shadow">
        @include('partials.list-toolbar', ['placeholder' => 'Cari nama peminjam atau nomor transaksi'])

        <div class="table-wrapper">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th class="d-none d-sm-table-cell">No.</th>
                        <th>Peminjam</th>
                        <th class="d-none d-md-table-cell">Tanggal</th>
                        <th class="d-none d-md-table-cell">Barang</th>
                        <th class="d-none d-lg-table-cell">Jaminan</th>
                        <th>Status</th>
                        <th class="text-end"><span class="visually-hidden">Aksi</span></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $transaction)
                        <tr>
                            <td class="d-none d-sm-table-cell text-gray-500">#{{ $transaction->id }}</td>
                            <td>
                                <div class="app-cell-main">
                                    @include('partials.avatar', ['name' => $transaction->member?->name ?? '?', 'photo' => $transaction->member?->photo, 'size' => 36])
                                    <span>
                                        <span class="title d-block">{{ $transaction->member?->name ?? 'Member terhapus' }}</span>
                                        <span class="sub">{{ $transaction->member?->hp }}</span>
                                    </span>
                                </div>
                            </td>
                            <td class="d-none d-md-table-cell small text-nowrap">{{ \Illuminate\Support\Carbon::parse($transaction->transaction_date)->locale('id')->translatedFormat('j M Y') }}</td>
                            <td class="d-none d-md-table-cell">{{ $transaction->total }}</td>
                            <td class="d-none d-lg-table-cell">{{ $transaction->collateral }}</td>
                            <td>@include('partials.status', ['status' => $transaction->status, 'type' => 'transaction'])</td>
                            <td class="text-end">
                                <a class="btn btn-sm btn-outline-gray-600" href="{{ route('transactions.view', $transaction) }}">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="app-empty">
                                <i class="fas fa-file-alt" aria-hidden="true"></i>
                                {{ request('search') ? 'Tidak ada data yang cocok dengan pencarian.' : 'Belum ada transaksi.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @include('partials.list-footer', ['paginator' => $transactions])
    </div>
@endsection
