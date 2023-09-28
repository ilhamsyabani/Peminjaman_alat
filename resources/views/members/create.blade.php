@extends('layouts.app')

@section('custom_styles')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
@endsection

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
                    <li class="breadcrumb-item active" aria-current="page">Member</li>
                </ol>
            </nav>
            <h3 class="h4">Member</h3>
            <p class="mb-0">Pengelolaan data anggota.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-0 shadow components-section">
                <div class="card-body">
                    <div class="row mb-4">
                        <form action="{{ route('members.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="col-sm-8">
                                <!-- Form -->
                                <div class="col-ms-8 mb-5">
                                    <div id="my_camera"></div>
                                    <br />
                                    <div id="results">Your captured image will appear here...</div>
                                    <label for="image" class="form-label">Input Gambar Barang</label>
                                    <input class="btn btn-primary mt-2" type="button" value="Take Snapshot"
                                        onClick="take_snapshot()">
                                    <input type="hidden" name="photo" class="image-tag">
                                </div>

                                <!-- Form -->
                                <div class="mb-4">
                                    <label for="name">Nama Member</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" aria-describedby="barangHelp">
                                    <small id="name" class="form-text text-muted"></small>
                                </div>
                                @error('name')
                                    <div class="invalid-feedback"> {{ $message }}</div>
                                @enderror
                                <!-- End of Form -->

                                <!-- Form -->
                                <div class="mb-4">
                                    <label for="email">Email Member</label>
                                    <input type="text" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" aria-describedby="barangHelp">
                                    <small id="email" class="form-text text-muted">masukan email yang akatif</small>
                                </div>
                                @error('email')
                                    <div class="invalid-feedback"> {{ $message }}</div>
                                @enderror
                                <!-- End of Form -->

                                <!-- Form -->
                                <div class="mb-4">
                                    <label for="identity_number">Nomor Identisa</label>
                                    <input type="text" class="form-control @error('identity_number') is-invalid @enderror"
                                        id="identity_number" name="identity_number" aria-describedby="barangHelp">
                                    <small id="nama" class="form-text text-muted">Nomor identitas </small>
                                    @error('identity_number')
                                        <div class="invalid-feedback"> {{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- End of Form -->

                                <!-- Form -->
                                <div class="mb-4">
                                    <label for="hp">Nomor Telephone</label>
                                    <input type="text" class="form-control @error('hp') is-invalid @enderror"
                                        id="hp" name="hp" aria-describedby="barangHelp">
                                    <small id="nama" class="form-text text-muted">Gunakan No telfon aktif</small>
                                    @error('hp')
                                        <div class="invalid-feedback"> {{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- End of Form -->

                                <!-- Form -->
                                <div class="my-4">
                                    <label for="address">Alamat</label>
                                    <textarea class="form-control" placeholder="Masukan address lengkap " id="textarea" rows="4" spellcheck="false"
                                        name="address"></textarea>
                                    @error('address')
                                        <div class="invalid-feedback"> {{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- End of Form -->
                                <div class="my-4">
                                    <label for="info">Informasi tambahan</label>
                                    <textarea class="form-control" placeholder="Informasi terkait pengguna" id="textarea" rows="4"
                                        spellcheck="false" name="info"></textarea>
                                </div>
                                <!-- End of Form -->

                                <input type="hidden" name="status" value="belum meminjam">

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
    <script language="JavaScript">
        Webcam.set({
            width: 490,
            height: 350,
            image_format: 'jpeg',
            jpeg_quality: 90
        });

        Webcam.attach('#my_camera');

        function take_snapshot() {
            Webcam.snap(function(data_uri) {
                $(".image-tag").val(data_uri);
                document.getElementById('results').innerHTML = '<img src="' + data_uri + '"/>';
            });
        }
    </script>
@endsection
