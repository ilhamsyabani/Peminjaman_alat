@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Today's Users</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        2,300
                                        <span class="text-success text-sm font-weight-bolder">+3%</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Today's Users</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        2,300
                                        <span class="text-success text-sm font-weight-bolder">+3%</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">New Clients</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        +3,462
                                        <span class="text-danger text-sm font-weight-bolder">-2%</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Sales</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        $103,430
                                        <span class="text-success text-sm font-weight-bolder">+5%</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header pb-0 p-3">
                        <div class="row">
                            <div class="col-6 d-flex align-items-center">
                                <h6 class="mb-0">Cari data member</h6>
                            </div>
                            <div class="col-6 text-end">
                                <a class="btn bg-gradient-dark mb-0" href="javascript:;"><i
                                        class="fas fa-plus"></i>&nbsp;&nbsp;Tambah member</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="mb-4">
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
                                    <input type="text" class="form-control" placeholder="cari data barang disini"
                                        name="search" id="searchmember" value="{{ old('search') ?? '' }}" autofocus>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header pb-0 px-3">
                        <h6 class="mb-3">Informasi member</h6>
                    </div>
                    <div class="card-body pt-4 p-3">
                        @if ($member)
                            <ul class="list-group">
                                <li class="list-group-item border-0 d-flex p-4 mb-2 mt-3 bg-gray-100 border-radius-lg">
                                    <div class="d-flex flex-column px-4 col-3">
                                        <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->image }}">
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6 style="font-size: 14px;">{{ $member->name }}</h6>
                                        <span style="font-size: 12px;" class="mb-0 text-xs">No handphone: <span
                                                class="text-dark font-weight-bold ms-sm-2">{{ $member->hp }}</span></span>
                                        <span style="font-size: 12px;" class="mb-0 text-xs">Email: <span
                                                class="text-dark ms-sm-2 font-weight-bold">{{ $member->email }}</span></span>
                                        <span style="font-size: 12px;" class="text-xs">Alamat: <span
                                                class="text-dark ms-sm-2 font-weight-bold">{{ $member->address }}</span></span>
                                        <div class="d-flex">
                                            <button
                                                class="btn btn-sm btn-gray-800 align-items-center mt-2  mb-2 d-flex flex-column"
                                                data-bs-toggle="modal" data-bs-target="#modalProduct">tambah
                                                barang</button>
                                            <form action="{{ url('/processmember') }}" method="POST">
                                                @csrf
                                                <input type="hidden" value="{{ $member->id }}" name="id">
                                                <input type="hidden" value="tidak_ada" name="status">
                                                <button
                                                    class="btn btn-sm btn-red-200 align-items-center m-2 d-flex flex-column">batalkan</button>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        @else
                            <ul class="list-group" id="search-results">
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-header pb-0 p-3">
                        <div class="row">
                            <div class="col-6 d-flex align-items-center mb-3">
                                <h6 class="mb-0">Daftar barang</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3 pb-0">
                        <form method="post" action="{{ route('transactions.store') }}">
                            @csrf
                            <ul class="list-group">
                                @foreach ($products as $product)
                                    <li
                                        class="list-group-item border-0 d-flex justify-content-start ps-0 mb-2 border-radius-lg">
                                        <div class="d-flex flex-column">
                                            <input type="checkbox" class="form-check-input" name="products[]"
                                                value="{{ $product->id }}">
                                        </div>
                                        <div class="d-flex flex-column px-2">
                                            <img src="{{ asset('storage/' . $product->image) }}" style="height:50px"
                                                alt="">
                                        </div>
                                        <div class="d-flex flex-column px-2">
                                            <h6 class="mb-1 text-dark font-weight-bold text-sm">{{ $product->name }}</h6>
                                            <span class="text-xs" style="font-size:12px">{{ $product->location->name }},
                                                {{ $product->room->name }}, {{ $product->cabinet->name }}</span>
                                        </div>

                                    </li>
                                @endforeach
                            </ul>
                            @if ($member)
                            <input type="hidden" name="member_id" value="{{ $member->id }}">
                            @endif
                            <button class="btn btn-sm btn-red-200 align-items-center m-2" type="submit">Ajukan
                                pinjaman</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalProduct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambahkan barang pinjaman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col mb-3">
                        <label for="username" class="form-label">Cari barang</label>
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
                            <input type="text" class="form-control" placeholder="cari data barang disini"
                                name="search" id="searchproduct" value="{{ old('search') ?? '' }}" autofocus>
                        </div>
                    </div>
                    <div class="col-sm-12 mb-3">
                        <ul class="list-group" id="results-product">

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        $(document).ready(function() {

            readData();

            $("#searchmember").keyup(function() {
                var strcari = $(this).val();
                if (strcari != "") {
                    $.ajax({
                        type: "get",
                        url: "{{ url('/search-member') }}",
                        data: "search=" + strcari, // Send data as an object
                        success: function(data) {
                            $("#search-results").html(data);
                        }
                    });
                } else {
                    // Handle empty search case if needed
                    readData();
                    // $("#search-results").html('');
                }
            });

            $("#searchproduct").keyup(function() {
                var strcari = $(this).val();
                if (strcari != "") {
                    $.ajax({
                        type: "get",
                        url: "{{ url('/search-product') }}",
                        data: "search=" + strcari, // Send data as an object
                        success: function(data) {
                            $("#results-product").html(data);
                        }
                    });
                } else {
                    // Handle empty search case if needed
                    readData1();
                    // $("#search-results").html('');
                }
            });
        });

        function readData() {
            $.get("{{ url('/search-no-result') }}", {},
                function(data, status) {
                    $("#search-results").html(data);
                });
        }

        function readData1() {
            $.get("{{ url('/search-no-result') }}", {},
                function(data, status) {
                    $("#results-product").html(data);
                });
        }
    </script>
@endsection
