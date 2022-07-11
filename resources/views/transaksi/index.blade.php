@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="#" class="keychainify-checked">
                            <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#" class="keychainify-checked">Volt</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Transactions</li>
                </ol>
            </nav>
            <h3 class="h4">Dashboard</h3>
            <p class="mb-0">Your web analytics dashboard template.</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('transaksi.create') }}"
                class="btn btn-sm btn-gray-800 d-inline-flex align-items-center keychainify-checked">
                <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                    </path>
                </svg>
                New Plan
            </a>
        </div>
    </div>
    <div class="table-settings mb-4">
        <form class="needs-validation" novalidate="">
            <div class="row align-items-center justify-content-between">
                <div class="col-4  text-end">
                    <div class="input-group">
                        <label class="my-1 me-2" for="status">Status Transaksi</label>
                        <select class="form-select @error('status') is-invalid @enderror"id="status" name="status"
                            aria-label="Default select example"value="{{ old('status') }}">
                            <option value="proses">Proses</option>
                            <option value="selesai">Selesai</option>
                            <option value="">Semua</option>
                        </select>
                    </div>
                </div>
                <div class="col col-md-6 col-lg-3 col-xl-4">
                    <div class="input-group me-2 me-lg-3 fmxw-400">
                        <span class="input-group-text">
                            <svg class="icon icon-xs" x-description="Heroicon name: solid/search"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </span>
                        <input type="text" class="form-control" placeholder="Search orders">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="card card-body border-0 shadow table-wrapper table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="border-gray-200">#</th>
                    <th class="border-gray-200">Nama Peminjam</th>
                    <th class="border-gray-200">Nama Barang</th>
                    <th class="border-gray-200">No</th>
                    <th class="border-gray-200">Tangal</th>
                    <th class="border-gray-200">Status</th>
                    <th class="border-gray-200">Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Item -->
                @foreach ($transctions as $transaksi)
                    <tr>
                        <td>
                            <a href="#" class="fw-bold keychainify-checked">
                                {{ $transaksi->id }}
                            </a>
                        </td>
                        <td>
                            <span class="fw-normal">{{ $transaksi->member->username }}</span>
                        </td>
                        <td><span class="fw-normal">{{ $transaksi->barang->nama }}</span></td>
                        <td><span class="fw-normal">{{ $transaksi->member->hp }}</span></td>
                        <td><span class="fw-bold">{{ $transaksi->created_at->format('d-m-Y') }}</span></td>
                        <td><span class="fw-bold text-warning">{{ $transaksi->status }}</span></td>
                        <td>
                            <div class="btn-group">
                                @if ($transaksi->status === 'proses')
                                    <form action="{{ route('kembali') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $transaksi->id }}">
                                        <input type="hidden" name="barang_id" value="{{ $transaksi->barang_id }}">
                                        <button class="btn btn-sm btn-primary">
                                            Kembali</button>
                                    </form>
                                @else
                                    <a href="{{ route('barang.show', $transaksi->barang->id) }}"
                                        class="btn btn-link">periksa</a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                <!-- Item -->
            </tbody>
        </table>
        <div class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
            <nav aria-label="Page navigation example">
                {{ $transctions->links() }}
            </nav>
            <div class="fw-normal small mt-4 mt-lg-0">Showing <b>5</b> out of <b>25</b> entries</div>
        </div>
    </div>
@endsection
