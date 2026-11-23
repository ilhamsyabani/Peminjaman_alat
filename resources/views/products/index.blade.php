@extends('layouts.app')

@section('title', 'Barang')

@section('content')
    @include('partials.page-header', ['title' => 'Barang', 'crumbs' => [['Barang', null]], 'subtitle' => 'Kelola inventaris barang yang dapat dipinjam.', 'action' => [route('products.create'), 'Tambah barang', 'fa-plus']])
    <div class="card card-body border-0 shadow">
        @include('partials.list-toolbar', [
            'placeholder' => 'Cari nama atau kode barang',
            'filter' => ['name' => 'filter', 'label' => 'Filter status', 'options' => [
                'all' => 'Semua status', 'tersedia' => 'Tersedia', 'menunggu persetujuan' => 'Dipinjam',
                'process' => 'Dipilih di dashboard', 'kosong' => 'Tidak tersedia',
            ]],
        ])

        <div class="table-wrapper">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Barang</th>
                        <th class="d-none d-md-table-cell">Lokasi</th>
                        <th class="d-none d-xl-table-cell">Keterangan</th>
                        <th>Status</th>
                        <th class="text-end"><span class="visually-hidden">Aksi</span></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>
                                <a href="{{ route('products.show', $product) }}" class="app-cell-main">
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="" class="app-thumb" loading="lazy">
                                    @else
                                        <span class="app-thumb"><i class="fas fa-box" aria-hidden="true"></i></span>
                                    @endif
                                    <span>
                                        <span class="title d-block">{{ $product->name }}</span>
                                        <span class="sub">{{ $product->code }}</span>
                                    </span>
                                </a>
                            </td>
                            <td class="d-none d-md-table-cell small">
                                {{ $product->location?->name }}<br>
                                <span class="text-gray-500">{{ $product->room?->name }} · {{ $product->cabinet?->name ?? 'Tanpa lemari' }}</span>
                            </td>
                            <td class="d-none d-xl-table-cell small text-gray-600 text-wrap" style="min-width: 180px; max-width: 260px">{{ \Illuminate\Support\Str::limit($product->info, 80) ?: '—' }}</td>
                            <td>@include('partials.status', ['status' => $product->status, 'type' => 'product'])</td>
                            <td>
                                <div class="app-actions">
                                    <a class="app-icon-btn" href="{{ route('products.edit', $product) }}" title="Ubah" aria-label="Ubah {{ $product->name }}">
                                        <i class="fas fa-pen" aria-hidden="true"></i>
                                    </a>
                                    <form action="{{ route('products.destroy', $product) }}" method="post">
                                        @method('delete')
                                        @csrf
                                        <button class="app-icon-btn app-icon-btn--danger" title="Hapus" aria-label="Hapus {{ $product->name }}"
                                            onclick="return confirm('Hapus barang {{ e(addslashes($product->name)) }}?')">
                                            <i class="fas fa-trash-alt" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="app-empty">
                                <i class="fas fa-box-open" aria-hidden="true"></i>
                                {{ request('search') || request('filter', 'all') !== 'all' ? 'Tidak ada barang yang cocok dengan pencarian.' : 'Belum ada barang. Tambahkan barang pertama.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @include('partials.list-footer', ['paginator' => $products])
    </div>
@endsection
