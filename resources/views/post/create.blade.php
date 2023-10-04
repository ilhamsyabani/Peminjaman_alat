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
                    <li class="breadcrumb-item active" aria-current="page">Post</li>
                    <li class="breadcrumb-item active" aria-current="page">Buat</li>
                </ol>
            </nav>
            <h3 class="h4">Post</h3>
            <p class="mb-0">Manejemen dan pengelolaan content lap TP.</p>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mb-2">
            <div class="card border-0 shadow components-section">
                <div class="card-body">
                    <div class="row mb-2">
                        <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="col-sm-8">
                                <!-- Form -->
                                <div class="mb-3">
                                    <img id="image-preview" alt="image preview" class="col-sm-6" />
                                    <br />
                                    <label for="gambar" class="form-label">Gambar Barang</label>
                                    <small id="gambar" class="form-text text-muted">Ukuran gambar maksimal 1MB dengan
                                        resolusi 800 x 1200 px</small>
                                    <input class="form-control @error('gambar') is-invalid @enderror" type="file"
                                        id="image-source" name="gambar" onchange="previewImage();">
                                    @error('gambar')
                                        <div class="invalid-feedback"> {{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- End of Form -->

                                <!-- Form -->
                                <div class="mb-2">
                                    <label for="title">Judul Postingan</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        id="title" name="title" aria-describedby="barangHelp">
                                    <small id="title" class="form-text text-muted"></small>
                                    @error('title')
                                        <div class="invalid-feedback"> {{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- End of Form -->

                                <!-- Form -->
                                <div class="mb-2">
                                    <label class="my-1 me-2" for="category">Kategori Postingan</label>
                                    <select class="form-select @error('category') is-invalid @enderror" id="category"
                                        name="category" aria-label="Default select example">
                                        <option value="berita">berita</option>
                                        <option value="info">info</option>
                                        <option value="kegiatan">kegiatan</option>
                                        <option value="about">about</option>
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback"> {{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 mt-4">
                                    <label for="content" class="form-label">Content</label>
                                    <input id="content" type="hidden" name="content" value="{{ old('content') }}">
                                    <trix-editor input="content"></trix-editor>
                                    @error('content')
                                        <div class="invalid-feedback"> {{ $message }}</div>
                                    @enderror
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
        document.getElementById("image-preview").style.display = "none";

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
