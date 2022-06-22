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
        {{-- <div class="btn-toolbar mb-2 mb-md-0">
            <a href="#" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center keychainify-checked">
                <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                    </path>
                </svg>
                New Plan
            </a>
        </div> --}}
    </div>
    {{-- <div class="table-settings mb-4">
        <div class="row align-items-center justify-content-between">
            <div class="col col-md-6 col-lg-3 col-xl-4">
                <div class="input-group me-2 me-lg-3 fmxw-400">
                    <span class="input-group-text">
                        <svg class="icon icon-xs" x-description="Heroicon name: solid/search"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </span>
                    <input type="text" class="form-control" placeholder="Search orders">
                </div>
            </div>
            <div class="col-4 col-md-2 col-xl-1 ps-md-0 text-end">
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
            </div>
        </div>
    </div> --}}
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-0 shadow components-section">
                <div class="card-body">
                    <div class="row mb-4">
                        <form action="{{ route('barang.update', $barang->id) }}" method="post"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="col-sm-8">
                                <!-- Form -->
                                <div class="mb-3">
                                    @if ($barang->image)
                                        <img src="{{ asset('storage/' . $barang->image) }}" class="col-sm-6"
                                            id="image-preview" />
                                    @else
                                        <img id="image-preview" alt="image preview" class="col-sm-6" />
                                    @endif
                                    <br />
                                    <label for="image" class="form-label">Input Gambar Barang</label>
                                    <input class="form-control @error('image') is-invalid @enderror" type="file"
                                        id="image-source" name="image" onchange="previewImage();"
                                        value="{{ $barang->image }}">
                                </div>
                                @error('image')
                                    <div class="invalid-feedback"> {{ $message }}</div>
                                @enderror
                                <!-- End of Form -->

                                <!-- Form -->
                                <div class="mb-4">
                                    <label for="kode">Kode Barang</label>
                                    <input type="text" class="form-control @error('kode') is-invalid @enderror"
                                        id="kode" name="kode" aria-describedby="barangHelp"
                                        value="{{ old('kode', $barang->kode) }}">
                                    <small id="kode" class="form-text text-muted">kode ID barang yang tertera pada
                                        label</small>
                                </div>
                                @error('kode')
                                    <div class="invalid-feedback"> {{ $message }}</div>
                                @enderror
                                <!-- End of Form -->

                                <!-- Form -->
                                <div class="mb-4">
                                    <label for="nama">Nama Barang</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                        id="nama" name="nama" aria-describedby="barangHelp"
                                        value="{{ old('nama', $barang->nama) }}">
                                    <small id="nama" class="form-text text-muted">kode ID barang yang tertera pada
                                        label</small>
                                </div>
                                @error('nama')
                                    <div class="invalid-feedback"> {{ $message }}</div>
                                @enderror
                                <!-- End of Form -->

                                <!-- Form -->
                                <div class="mb-4">
                                    <label for="kondisi">Kondisi Barang</label>
                                    <input type="text" class="form-control @error('kondisi') is-invalid @enderror"
                                        id="kondisi" name="kondisi" aria-describedby="barangHelp"
                                        value="{{ old('kondisi', $barang->kondisi) }}">
                                    <small id="nama" class="form-text text-muted">kode ID barang yang tertera pada
                                        label</small>
                                </div>
                                @error('kondisi')
                                    <div class="invalid-feedback"> {{ $message }}</div>
                                @enderror
                                <!-- End of Form -->

                                <!-- Form -->
                                <div class="mb-4">
                                    <label class="my-1 me-2" for="status">Status Barang</label>
                                    <select class="form-select @error('kondisi') is-invalid @enderror"id="status"
                                        name="status" aria-label="Default select example"
                                        value="{{ old('status', $barang->status) }}">
                                        <option value="tersedia">tersedia</option>
                                        <option value="kosong">kosong</option>
                                    </select>
                                </div>
                                @error('status')
                                    <div class="invalid-feedback"> {{ $message }}</div>
                                @enderror
                                <!-- End of Form -->
                                <div class="mb-4">
                                    <div class="form-group">
                                        <label for="country">lokasi</label>
                                        <select class="form-select" id="country-dropdown" name="location_id">
                                            <option value="">Select Country</option>
                                            @foreach ($countries as $country)
                                                @if (old('location_id', $barang->location_id) == $country->id)
                                                    <option value="{{ $country->id }}" selected>
                                                        {{ $country->name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $country->id }}">
                                                        {{ $country->name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="form-group">
                                        <label for="state">Ruang</label>
                                        <select class="form-select" id="state-dropdown" name="room_id">
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="form-group">
                                        <label for="city">Lemari</label>
                                        <select class="form-select" id="city-dropdown" name="locker_id">
                                        </select>
                                    </div>
                                </div>

                                <!-- End of Form -->

                                <!-- Form -->
                                <div class="my-4">
                                    <label for="textarea">Example textarea</label>
                                    <textarea class="form-control" name="keterangan" placeholder="Enter your message..." id="textarea" rows="4"
                                        spellcheck="false"></textarea>
                                </div>
                                <!-- End of Form -->
                                <div class="my-4 d-inline-flex align-content-end">
                                    <button class="btn btn-sm btn-gray-800 d-inline-flex">simpan</button>
                                </div>

                            </div>
                        </form>
                        <div class="col-lg-4 col-sm-6">
                        </div>
                    </div>
                </div>
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
                        $('#state-dropdown').html('<option value="">Select State</option>');
                        $.each(result.states, function(key, value) {
                            $("#state-dropdown").append('<option value="' + value.id +
                                '">' + value.name + '</option>');
                        });
                        $('#city-dropdown').html(
                            '<option value="">Select State First</option>');
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
                        $('#city-dropdown').html('<option value="">Select City</option>');
                        $.each(result.cities, function(key, value) {
                            $("#city-dropdown").append('<option value="' + value.id +
                                '">' + value.name + '</option>');
                        });
                    }
                });
            });
        });
    </script>
    <script>
        function previewImage() {
            document.getElementById("image-preview").style.display = "block";
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("image-source").files[0]);

            oFReader.onload = function(oFREvent) {
                document.getElementById("image-preview").src = oFREvent.target.result;
            };
        };
    </script>
@endsection
