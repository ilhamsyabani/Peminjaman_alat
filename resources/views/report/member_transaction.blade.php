@extends('layouts.app')

@section('title', 'Riwayat ' . $member->name)

@section('content')
    @include('partials.page-header', [
        'title' => 'Riwayat peminjaman',
        'subtitle' => $member->name,
        'crumbs' => [['Laporan', null], ['Member', route('report.member')], [$member->name, null]],
    ])

    @php($transaksi = $member->transaction()->with('transactionitem.product')->latest('transaction_date')->get())

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h2 class="h6 mb-0">Semua transaksi</h2>
                    <span class="small text-gray-500">{{ $transaksi->count() }} transaksi</span>
                </div>
                <div class="card-body">
                    @forelse ($transaksi as $transaction)
                        <a href="{{ route('transactions.view', $transaction) }}" class="app-list-row">
                            <div class="min-w-0">
                                <div class="fw-bold text-gray-900">
                                    #{{ $transaction->id }} ·
                                    {{ \Illuminate\Support\Carbon::parse($transaction->transaction_date)->locale('id')->translatedFormat('j F Y') }}
                                </div>
                                <div class="small text-gray-500 text-truncate">
                                    {{ $transaction->transactionitem->map(fn ($i) => $i->product?->name)->filter()->implode(', ') ?: 'Tanpa barang' }}
                                    · Jaminan {{ $transaction->collateral }}
                                </div>
                            </div>
                            @include('partials.status', ['status' => $transaction->status, 'type' => 'transaction'])
                        </a>
                    @empty
                        <p class="app-hint mb-0">Member ini belum pernah meminjam.</p>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            @include('transaction._member', ['member' => $member])
        </div>
    </div>
@endsection
