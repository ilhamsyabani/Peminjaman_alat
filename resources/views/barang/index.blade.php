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
            <a href="{{ route('barang.create') }}"
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
    <div class="table-settings mb-4">
        <form class="needs-validation" novalidate="">
            <div class="row justify-content-between">
                <div class="col col-md-4 col-lg-3 col-xl-4">
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
                        <input type="text" class="form-control" placeholder="Search orders" name="search">
                    </div>
                </div>
                {{-- <div class="col col-md-4 col-xl-4">
                <div class="input-group">
                    <label class="my-1 me-2" for="status">Lokasi Barang</label>
                    <select class="form-select @error('kondisi') is-invalid @enderror"id="status" name="status"
                        aria-label="Default select example">
                        <option selected="">Open this select menu</option>
                        <option value="tersedia">tersedia</option>
                        <option value="kosong">kosong</option>
                    </select>
                </div>
            </div> --}}
                <div class="col col-md-4 col-xl-4">
                    <div class="input-group">
                        <label class="my-1 me-2" for="status">Ruang Barang</label>
                        <select class="form-select @error('room_id') is-invalid @enderror"id="room" name="room"
                            aria-label="Default select example">
                            <option></option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}">
                                    {{ $room->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>


                {{-- <div class="col-4 col-md-2 col-xl-1 ps-md-0 text-end">
                <div class="dropdown">
                    <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-1"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-xs dropdown-menu-end pb-0">
                        <span class="small ps-3 fw-bold text-dark">Show</span>
                        <a class="dropdown-item d-flex align-items-center fw-bold keychainify-checked" href="#">10
                            <svg class="icon icon-xxs ms-auto" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg></a>
                        <a class="dropdown-item fw-bold keychainify-checked" href="#">20</a>
                        <a class="dropdown-item fw-bold rounded-bottom keychainify-checked" href="#">30</a>
                    </div>
                </div>
            </div> --}}
            </div>
        </form>
    </div>
    <div class="card card-body border-0 shadow table-wrapper table-responsive">
        @if ($barangs->count())
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="border-gray-200">#</th>
                        <th class="border-gray-200">Photo</th>
                        <th class="border-gray-200">Nama</th>
                        <th class="border-gray-200">Kondisi</th>
                        <th class="border-gray-200">Lokasi</th>
                        <th class="border-gray-200">Status</th>
                        <th class="border-gray-200 d-flex justify-content-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($barangs as $barang)
                        <!-- Item -->
                        <tr>
                            <td>
                                {{ $barang->kode }}
                            </td>
                            <td>
                                <span class="fw-normal">{{ $barang->kode }}</span>
                            </td>
                            <td><span class="fw-normal">{{ $barang->nama }}</span></td>
                            <td><span class="fw-normal">{{ $barang->kondisi }}</span></td>
                            <td><span class="fw-bold">{{ $barang->location->name }} ,{{ $barang->room->name }},
                                    {{ $barang->locker->name }}</span></td>
                            <td><span class="fw-bold text-warning">{{ $barang->status }}</span></td>
                            <td class="d-flex justify-content-center">
                                <div class="btn-group">
                                    <a class="rounded-top keychainify-checked p-2"
                                        href="{{ route('barang.show', $barang) }}"><span
                                            class="fas fa-eye me-2"></span></a>
                                    <a class="keychainify-checked p-2" href="{{ route('barang.edit', $barang) }}"><span
                                            class="fas fa-edit me-2"></span></a>
                                    <form action="{{ route('barang.destroy', $barang) }}" method="post">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-link text-danger text-align-center keychainify-checked p-2"
                                            onclick="return confirm('Apakah Anda Yakin?')"><span
                                                class="fas fa-trash-alt me-2"></span></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-center">No Data found..!</p>
        @endif
        <div class="mt-4">
            {{ $barangs->links() }}
        </div>
    </div>
@endsection
