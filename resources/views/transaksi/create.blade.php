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
    </div>

    <div class="row">
        <div class="col-12 col-xl-8">
            <div class="card card-body border-0 shadow mb-4">
                <p> Cari Barang</p>
                <form action="#">
                    <div class="row">
                        <div class="col-sm-9 mb-3">
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
            {{-- <--product list--> --}}

            <div class="col-12 py-3">
                <div class="row justify-content-left">
                    @if ($barangs->count())
                        @foreach ($barangs as $barang)
                            <div class="col-md-8 col-lg-6 col-xl-4 py-2">
                                <div class="card" style="border-radius: 15px;">
                                    <div class="bg-image hover-overlay ripple ripple-surface ripple-surface-light"
                                        data-mdb-ripple-color="light">
                                        <img src="{{ asset('storage/' . $barang->image) }}"
                                            style="border-top-left-radius: 15px; border-top-right-radius: 15px;"
                                            class="img-fluid" alt="barang" />
                                    </div>
                                    <div class="card-body pb-0">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <p><a href="#!" class="text-dark">{{ $barang->nama }}</a></p>
                                                <p class="small text-muted">{{ $barang->status }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-0" />
                                    <div class="card-body">
                                        <div class="d-flex justify-content-center align-items-center mb-1">
                                            <form action="{{ route('transaksi.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="barang_id" value="{{ $barang->id }}">
                                                <input type="hidden" name="member_id"
                                                    value="{{ Session::get('user_id') }}">
                                                <button class="btn btn-sm btn-gray-800 d-inline-flex"
                                                    {{ $barang->status === 'kosong' ? 'disabled' : '' }}>Ajukan
                                                    Pinjaman</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-center">No Items found..!</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-4">
            <div class="row">
                <div class="mb-4">
                    @include('layouts.crat')
                </div>
            </div>
        </div>
    </div>
@endsection
