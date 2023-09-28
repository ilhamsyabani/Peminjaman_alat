@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-2 mb-md-0">
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
                    <li class="breadcrumb-item active" aria-current="page">Barang</li>
                    <li class="breadcrumb-item active" aria-current="page">Buat</li>
                </ol>
            </nav>
            <h3 class="h4">Barang</h3>
            <p class="mb-0">Manejemen dan pengelolaan barang.</p>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mb-2">
            <div class="card border-0 shadow components-section">
                <div class="card-body">
                    <div class="row mb-2">
                        <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="col-sm-8">
                                <!-- Form -->
                                <div class="mb-3">
                                    <img id="image-preview" alt="image preview" class="col-sm-6" />
                                    <br />
                                    <label for="image" class="form-label">Gambar Barang</label>
                                    <small id="kode" class="form-text text-muted">Ukuran gambar maksimal 1MB dengan resolusi 1200 x 1200 px</small>
                                    <input class="form-control @error('image') is-invalid @enderror" type="file"
                                        id="image-source" name="image" onchange="previewImage();">
                                        @error('image')
                                        <div class="invalid-feedback"> {{ $message }}</div>
                                    @enderror
                                </div>
                               
                                <!-- End of Form -->

                                <!-- Form -->
                                <div class="mb-2">
                                    <label for="kode">Kode Barang</label>
                                    <input type="text" class="form-control @error('kode') is-invalid @enderror"
                                        id="kode" name="kode" aria-describedby="barangHelp">
                                    <small id="kode" class="form-text text-muted">kode ID barang yang tertera pada
                                        label</small>
                                        @error('kode')
                                            <div class="invalid-feedback"> {{ $message }}</div>
                                        @enderror
                                </div>
                                <!-- End of Form -->

                                <!-- Form -->
                                <div class="mb-2">
                                    <label for="name">Nama Barang</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" aria-describedby="barangHelp">
                                        @error('name')
                                            <div class="invalid-feedback"> {{ $message }}</div>
                                        @enderror
                                </div>
                                <!-- End of Form -->

                                <!-- Form -->
                                <div class="mb-2">
                                    <label for="info">Informasi Barang</label>
                                    <input type="text" class="form-control @error('info') is-invalid @enderror"
                                        id="info" name="info" aria-describedby="barangHelp">
                                    <small id="info" class="form-text text-muted">Informasi terkait kelengkapan barang</small>
                                        @error('info')
                                            <div class="invalid-feedback"> {{ $message }}</div>
                                        @enderror
                                </div>
                                <!-- End of Form -->

                                <!-- Form -->
                                <div class="mb-2">
                                    <label class="my-1 me-2" for="status">Status Barang</label>
                                    <select class="form-select @error('info') is-invalid @enderror"id="status"
                                        name="status" aria-label="Default select example">
                                        <option value="tersedia">tersedia</option>
                                        <option value="kosong">kosong</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback"> {{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- End of Form -->
                                <div class="mb-2">
                                    <div class="form-group">
                                        <label for="country">lokasi</label>
                                        <select class="form-select" id="country-dropdown" name="location_id">
                                            <option value="">Lokasi</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}">
                                                    {{ $country->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <div class="form-group">
                                        <label for="state">Ruang</label>
                                        <select class="form-select" id="state-dropdown" name="room_id">
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <div class="form-group">
                                        <label for="city">Lemari</label>
                                        <select class="form-select" id="city-dropdown" name="cabinet_id">
                                        </select>
                                    </div>
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
                        $('#state-dropdown').html('<option value="">Pilih Ruangan</option>');
                        $.each(result.states, function(key, value) {
                            $("#state-dropdown").append('<option value="' + value.id +
                                '">' + value.name + '</option>');
                        });
                        $('#city-dropdown').html(
                            '<option value="">Pilih Lemari</option>');
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
    <script>
        document.getElementById("image-preview").style.display ="none";
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
