@extends('layouts.app')

@section('title', 'Laporan barang')

@section('content')
    @include('partials.page-header', ['title' => 'Laporan barang', 'crumbs' => [['Laporan', null], ['Barang', null]], 'subtitle' => 'Riwayat peminjaman per barang.'])
    <div class="card card-body border-0 shadow">
        @include('partials.list-toolbar', ['placeholder' => 'Cari nama barang'])

        <div class="table-wrapper">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Barang</th>
                        <th class="d-none d-md-table-cell">Peminjam</th>
                        <th class="d-none d-sm-table-cell">Tanggal pinjam</th>
                        <th>Status</th>
                        <th class="text-end"><span class="visually-hidden">Aksi</span></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                        <tr>
                            <td>
                                <div class="app-cell-main">
                                    @if ($item->product?->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="" class="app-thumb" loading="lazy">
                                    @else
                                        <span class="app-thumb"><i class="fas fa-box" aria-hidden="true"></i></span>
                                    @endif
                                    <span>
                                        <span class="title d-block">{{ $item->product?->name ?? 'Barang terhapus' }}</span>
                                        <span class="sub">{{ $item->product?->code }}</span>
                                    </span>
                                </div>
                            </td>
                            <td class="d-none d-md-table-cell small">{{ $item->transaction?->member?->name ?? '—' }}<br><span class="text-gray-500">{{ $item->transaction?->member?->hp }}</span></td>
                            <td class="d-none d-sm-table-cell small text-nowrap">{{ $item->transaction ? \Illuminate\Support\Carbon::parse($item->transaction->transaction_date)->locale('id')->translatedFormat('j M Y') : '—' }}</td>
                            <td>@include('partials.status', ['status' => $item->status, 'type' => 'item'])</td>
                            <td class="text-end">
                                @if ($item->transaction)
                                    <a class="btn btn-sm btn-outline-gray-600" href="{{ route('transactions.view', $item->transaction) }}">Transaksi</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="app-empty">
                                <i class="fas fa-box" aria-hidden="true"></i>
                                {{ request('search') ? 'Tidak ada data yang cocok dengan pencarian.' : 'Belum ada barang yang dipinjam.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @include('partials.list-footer', ['paginator' => $items])
    </div>
@endsection
