@extends('layouts.app')

@section('title', 'Persetujuan peminjaman')

@section('content')
    @include('partials.page-header', [
        'title' => 'Persetujuan peminjaman',
        'subtitle' => 'Periksa barang, terima kartu jaminan, lalu setujui.',
        'crumbs' => [['Dashboard', route('transactions.create')], ['Persetujuan', null]],
    ])

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h2 class="h6 mb-0">Barang yang akan dipinjam</h2>
                    <span class="small text-gray-500">{{ $transaction->transactionitem->count() }} barang</span>
                </div>
                <div class="card-body">
                    @foreach ($transaction->transactionitem as $item)
                        <div class="app-list-row">
                            <div class="d-flex align-items-center gap-3 min-w-0">
                                @if ($item->product?->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="" class="app-thumb">
                                @else
                                    <span class="app-thumb"><i class="fas fa-box" aria-hidden="true"></i></span>
                                @endif
                                <div class="min-w-0">
                                    <div class="fw-bold text-gray-900">{{ $item->product?->name }}</div>
                                    <div class="small text-gray-500 text-truncate">
                                        {{ $item->product?->code }} · {{ $item->product?->location?->name }}, {{ $item->product?->room?->name }}{{ $item->product?->cabinet ? ', ' . $item->product->cabinet->name : '' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow mb-4">
                <div class="card-body">
                    @include('transaction._approve-form')
                </div>
            </div>
            @include('transaction._member', ['member' => $transaction->member])
        </div>
    </div>
@endsection
