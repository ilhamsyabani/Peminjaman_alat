@extends('layouts.app')

@section('title', 'Transaksi #' . $transaction->id)

@section('content')
    @include('partials.page-header', [
        'title' => 'Transaksi #' . $transaction->id,
        'subtitle' => 'Dibuat ' . \Illuminate\Support\Carbon::parse($transaction->transaction_date)->locale('id')->translatedFormat('l, j F Y'),
        'crumbs' => [['Peminjaman', route('transactions.index')], ['#' . $transaction->id, null]],
    ])

    @php
        $items = $transaction->transactionitem;
        $kembali = $items->where('status', 'selesai')->count();
    @endphp

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h2 class="h6 mb-0">Daftar barang</h2>
                    @if ($items->isNotEmpty())
                        <span class="small text-gray-500">{{ $kembali }} dari {{ $items->count() }} sudah dikembalikan</span>
                    @endif
                </div>
                <div class="card-body">
                    @forelse ($items as $item)
                        <div class="app-list-row">
                            <div class="d-flex align-items-center gap-3 min-w-0">
                                @if ($item->product?->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="" class="app-thumb">
                                @else
                                    <span class="app-thumb"><i class="fas fa-box" aria-hidden="true"></i></span>
                                @endif
                                <div class="min-w-0">
                                    <div class="fw-bold text-gray-900">{{ $item->product?->name ?? 'Barang terhapus' }}</div>
                                    <div class="small text-gray-500 text-truncate">
                                        {{ $item->product?->code }} · {{ $item->product?->location?->name }}, {{ $item->product?->room?->name }}{{ $item->product?->cabinet ? ', ' . $item->product->cabinet->name : '' }}
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2 flex-shrink-0">
                                @include('partials.status', ['status' => $item->status, 'type' => 'item'])
                                @if ($transaction->status === 'disetujui' && $item->status !== 'selesai')
                                    <form action="{{ route('transactions.return.product') }}" method="POST">
                                        @csrf
                                        <input type="hidden" value="{{ $item->id }}" name="id">
                                        <button class="btn btn-sm btn-outline-gray-600" type="submit">kembalikan</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="app-hint mb-0">Transaksi ini tidak memiliki barang.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="h6 text-gray-500 text-uppercase small fw-bold mb-0">Status</h2>
                        @include('partials.status', ['status' => $transaction->status, 'type' => 'transaction'])
                    </div>

                    @if ($transaction->status === 'diproses')
                        @include('transaction._approve-form')
                    @else
                        <dl class="app-dl app-dl--compact mb-3">
                            <dt>Jaminan</dt><dd>{{ $transaction->collateral }}</dd>
                            <dt>Jumlah</dt><dd>{{ $transaction->total }} barang</dd>
                        </dl>
                        @if ($transaction->status === 'selesai')
                            <div class="alert alert-success d-flex align-items-center mb-0" role="status">
                                <i class="fas fa-check-circle me-2" aria-hidden="true"></i>
                                Semua barang sudah dikembalikan. Jaminan dapat diserahkan kembali.
                            </div>
                        @else
                            <form action="{{ route('transactions.return') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $transaction->id }}">
                                <button class="btn btn-gray-800 w-100" type="submit"
                                    onclick="return confirm('Selesaikan pinjaman ini? Semua barang akan ditandai kembali.')">Selesaikan pinjaman</button>
                            </form>
                            <p class="small text-gray-500 mt-2 mb-0">Gunakan ini bila semua barang dikembalikan sekaligus.</p>
                        @endif
                    @endif
                </div>
            </div>

            @include('transaction._member', ['member' => $transaction->member])
        </div>
    </div>
@endsection
