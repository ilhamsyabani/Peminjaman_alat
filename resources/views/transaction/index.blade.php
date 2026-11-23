@extends('layouts.app')

@section('title', 'Peminjaman aktif')

@section('content')
    @include('partials.page-header', ['title' => 'Peminjaman aktif', 'crumbs' => [['Peminjaman', null]], 'subtitle' => 'Peminjaman yang sudah disetujui dan belum dikembalikan.', 'action' => [route('transactions.create'), 'Buat peminjaman', 'fa-plus']])
    <div class="card card-body border-0 shadow">
        @include('partials.list-toolbar', ['placeholder' => 'Cari nama peminjam'])

        <div class="table-wrapper">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th class="d-none d-sm-table-cell">No.</th>
                        <th>Peminjam</th>
                        <th class="d-none d-md-table-cell">Barang</th>
                        <th class="d-none d-md-table-cell">Jaminan</th>
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
                                        <span class="sub">Sejak {{ \Illuminate\Support\Carbon::parse($transaction->transaction_date)->locale('id')->translatedFormat('j M Y') }}</span>
                                    </span>
                                </div>
                            </td>
                            <td class="d-none d-md-table-cell">{{ $transaction->total }} barang</td>
                            <td class="d-none d-md-table-cell">{{ $transaction->collateral }}</td>
                            <td>@include('partials.status', ['status' => $transaction->status, 'type' => 'transaction'])</td>
                            <td>
                                <div class="app-actions">
                                    <a class="btn btn-sm btn-outline-gray-600" href="{{ route('transactions.view', $transaction) }}">Detail</a>
                                    <form action="{{ route('transactions.return') }}" method="POST">
                                        @csrf
                                        <input type="hidden" value="{{ $transaction->id }}" name="id">
                                        <button class="btn btn-sm btn-gray-800" type="submit"
                                            onclick="return confirm('Selesaikan transaksi #{{ $transaction->id }}? Semua barang akan ditandai kembali.')">Selesai</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="app-empty">
                                <i class="fas fa-exchange-alt" aria-hidden="true"></i>
                                {{ request('search') ? 'Tidak ada peminjaman yang cocok.' : 'Tidak ada peminjaman aktif saat ini.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @include('partials.list-footer', ['paginator' => $transactions])
    </div>
@endsection
