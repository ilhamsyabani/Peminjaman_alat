@extends('layouts.app')

@section('title', $product->name)

@section('content')
    @include('partials.page-header', [
        'title' => $product->name,
        'subtitle' => $product->code,
        'crumbs' => [['Barang', route('products.index')], [$product->name, null]],
        'action' => [route('products.edit', $product), 'Ubah barang', 'fa-pen'],
    ])

    @php($riwayat = $product->transactionItem()->with('transaction.member')->latest()->take(8)->get())

    <div class="row">
        <div class="col-lg-4 order-lg-2 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="app-image-drop mb-3">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="Foto {{ $product->name }}">
                        @else
                            <span><i class="fas fa-box" aria-hidden="true"></i>Belum ada foto</span>
                        @endif
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-gray-500 small fw-bold text-uppercase">Status</span>
                        @include('partials.status', ['status' => $product->status, 'type' => 'product'])
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8 order-lg-1">
            <div class="card border-0 shadow mb-4">
                <div class="card-body">
                    <h2 class="h6 mb-3">Detail</h2>
                    <dl class="app-dl">
                        <dt>Kode</dt><dd>{{ $product->code }}</dd>
                        <dt>Gedung</dt><dd>{{ $product->location?->name ?? '—' }}</dd>
                        <dt>Ruang</dt><dd>{{ $product->room?->name ?? '—' }}</dd>
                        <dt>Lemari</dt><dd>{{ $product->cabinet?->name ?? 'Tanpa lemari' }}</dd>
                        <dt>Keterangan</dt><dd>{{ $product->info ?: '—' }}</dd>
                    </dl>
                </div>
            </div>

            <div class="card border-0 shadow mb-4">
                <div class="card-body">
                    <h2 class="h6 mb-3">Riwayat peminjaman</h2>
                    @forelse ($riwayat as $item)
                        @if ($item->transaction)
                            <a href="{{ route('transactions.view', $item->transaction) }}" class="app-list-row">
                                <div class="min-w-0">
                                    <div class="fw-bold text-gray-900">{{ $item->transaction->member?->name ?? 'Member terhapus' }}</div>
                                    <div class="small text-gray-500">
                                        Transaksi #{{ $item->transaction->id }} ·
                                        {{ \Illuminate\Support\Carbon::parse($item->transaction->transaction_date)->locale('id')->translatedFormat('j F Y') }}
                                    </div>
                                </div>
                                @include('partials.status', ['status' => $item->status, 'type' => 'item'])
                            </a>
                        @endif
                    @empty
                        <p class="app-hint mb-0">Barang ini belum pernah dipinjam.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
