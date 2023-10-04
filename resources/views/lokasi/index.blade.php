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
                    <li class="breadcrumb-item active" aria-current="page">Lokasi</li>
                </ol>
            </nav>
            <h3 class="h4">Lokasi</h3>
            <p class="mb-0">Lokasi Penyimpanan Barang</p>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-sm-6 mb-4">
                    <div class="form-group">
                        <label for="country">lokasi</label>
                        <select class="form-select" id="country-dropdown">
                            <option value="">Pilih Lokasi</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}">
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 align-self-center mt-1">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal1">
                        Tambah Lokasi
                    </button>
                </div>
                <div class="col-sm-6 mb-4">
                    <div class="form-group">
                        <label for="state">Ruang</label>
                        <select class="form-select" id="state-dropdown">
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 align-self-center mt-1">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalRuang">
                        Tambah Ruang
                    </button>
                </div>
                <div class="col-sm-6 mb-4">
                    <div class="form-group">
                        <label for="city">Lemari</label>
                        <select class="form-select" id="city-dropdown">
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 align-self-center mt-1">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalLemari">
                        Tambah Lemari
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Lokasi Baru</h5>
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times<i
                        class="bi bi-x"></i></button> --}}
                </div>
                <form method="POST" action="{{ route('simpan.lokasi') }}">
                    <div class="modal-body">
                        @csrf
                        <div class="col-sm-8 mb-3">
                            <label for="name" class="form-label">Nama Lokasi</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                id="name" placeholder="{{ __('Nama Lokasi Baru') }}" required autofocus>
                        </div>
                        @error('name')
                            <div class="form-group custom-control">
                                <label class="">{{ $message }}</label>
                            </div>
                        @enderror
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalRuang" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tamabah Ruang Baru</h5>
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                </div>
                <form method="POST" action="{{ route('simpan.ruang') }}">
                    <div class="modal-body">
                        @csrf
                        <div class="col-sm-10 mb-3">
                            <label for="country">Lokasi</label>
                            <select class="form-control" id="country-dropdown" name="location_id">
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-10 mb-3">
                            <label for="name" class="form-label">Nama Ruang</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                id="name" placeholder="{{ __('Nama Lokasi Baru') }}" required autofocus>
                        </div>
                        @error('name')
                            <div class="form-group custom-control">
                                <label class="">{{ $message }}</label>
                            </div>
                        @enderror
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalLemari" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('simpan.lemari') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                        {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                    </div>
                    <div class="modal-body">
                        <div class="col-sm-10 mb-3">
                            <label for="country">Ruangan</label>
                            <select class="form-control" id="country-dropdown" name="room_id">
                                @foreach ($rooms as $country)
                                    <option value="{{ $country->id }}">
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-10 mb-3">
                            <label for="username" class="form-label">Nama Lemari/Penyimpanan</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                id="name" placeholder="{{ __('Nama Lokasi Baru') }}" required autofocus>
                        </div>

                        @error('name')
                            <div class="form-group custom-control">
                                <label class="">{{ $message }}</label>
                            </div>
                        @enderror
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#country-dropdown').on('change', function() {
                var country_id = this.value;
                $("#state-dropdown").html('');
                $.ajax({
                    url: "{{ url('get-states-by-country') }}",
                    type: "POST",
                    data: {
                        country_id: country_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#state-dropdown').html('<option value="">Pilih Ruangan</option>');
                        $.each(result.states, function(key, value) {
                            $("#state-dropdown").append('<option value="' + value.id +
                                '">' + value.name + '</option>');
                        });
                        $('#city-dropdown').html(
                            '<option value="">Piling Lemari</option>');
                    }
                });
            });
            $('#state-dropdown').on('change', function() {
                var state_id = this.value;
                $("#city-dropdown").html('');
                $.ajax({
                    url: "{{ url('get-cities-by-state') }}",
                    type: "POST",
                    data: {
                        state_id: state_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#city-dropdown').html('<option value="">Pilih Lemari</option>');
                        $.each(result.cities, function(key, value) {
                            $("#city-dropdown").append('<option value="' + value.id +
                                '">' + value.name + '</option>');
                        });
                    }
                });
            });
        });
    </script>
@endsection
