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
                    <li class="breadcrumb-item active" aria-current="page">Transaksi</li>
                </ol>
            </nav>
            <h3 class="h4">Transaksi</h3>
            <p class="mb-0">Manejemen dan pengelolaan transaksi peminjaman</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('transactions.create') }}"
                class="btn btn-sm btn-gray-800 d-inline-flex align-items-center keychainify-checked">
                <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                    </path>
                </svg>
                Tambah Barang
            </a>
        </div>
    </div>
    <div class="card card-body border-0 shadow table-wrapper table-responsive">
        @if (session('msg'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil</strong> {{ session('msg') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <form method="GET">
            <div class="row align-items-center justify-content-between">
                <div class="col-md-2">
                    <div class="input-group align-items-center">
                        <div class="col">
                            <label for="pagination" class="col-form-label m-1">Pagination:</label>
                        </div>
                        <div class="col">
                            <select id="pagination" name="pagination" class="form-control px-2" style="width: 40px;">
                                <option value="5" {{ old('pagination') == 5 ? 'selected' : '' }}>05</option>
                                <option value="10" {{ old('pagination') == 10 ? 'selected' : '' }}>10</option>
                                <option value="15" {{ old('pagination') == 15 ? 'selected' : '' }}>15</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="col-md-10">
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
                            <input type="text" class="form-control" placeholder="cari data barang disini" name="search"
                                value="{{ old('search') ?? '' }}" autofocus id="search">
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <table class="table mt-4 align-middle">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nama peminjaman</th>
                    <th>Jumlah barang</th>
                    <th>Jaminan</th>
                    <th>status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="transaction-list">
                <!-- Data akan dimuat melalui AJAX -->
                @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->id }}</td>
                        <td>
                            <div class="d-flex">
                                <div class="">
                                    <p class="fw-bold mb-0" style="font-size:13px">{{ $transaction->member->name }}</p>
                                    <p class="text-muted mb-0" style="font-size: 11px">{{ $transaction->transaction_date }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td>{{ $transaction->total }}</td>
                        <td>{{ $transaction->collateral }}</td>
                        <td>{{ $transaction->status }}</td>
                        <td>
                            <div class="btn-group">
                                <a class="keychainify-checked p-2"
                                    href="{{ route('transactions.view', $transaction) }}">view</a>
                                <form action="{{ route('transactions.return') }}" method="POST">
                                    @csrf
                                    <input type="hidden" value="{{ $transaction->id }}" name="id">
                                    <button class="keychainify-checked p-2" type="submit">Selesai</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div style="display: flex; width: 100%; justify-content: space-between; align-items: center;" class="mt-4 px-2">

            <p class="text-gray-500" style="font-size: 14px;">Menampilkan data ke {{ $transactions->firstItem() }} hingga
                {{ $transactions->lastItem() }}, dari
                {{ $transactions->total() }} data</p>


            {{ $transactions->links() }}

        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Fungsi untuk mengirim permintaan AJAX
            function fetchData() {
                var pagination = $('#pagination').val();
                var search = $('#search').val();
                var filter = $('#filter').val();

                console.log(pagination);

                $.ajax({
                    url: "{{ route('transactions.index') }}",
                    type: "GET",
                    data: {
                        pagination: pagination,
                        search: search,
                        filter: filter
                    },
                    success: function(data) {
                        $('#transaction-list').html(data);
                    }
                });
            }

            // Memuat data pertama kali
            fetchData();

            // Mengirim permintaan AJAX saat form di-submit atau nilai diubah
            $('#filter-form').on('submit change', function(e) {
                e.preventDefault();
                fetchData();
            });
        });
    </script>
@endsection
