{{-- Form informasi bersama (create & edit). Param: $post (nullable) --}}
@php
    $post = $post ?? null;
    $kategori = ['berita' => 'Berita', 'pengumuman' => 'Pengumuman', 'panduan' => 'Panduan', 'kegiatan' => 'Kegiatan', 'info' => 'Info'];
    $current = old('category', $post?->category ?? 'berita');
    // Pertahankan kategori lama yang tidak ada di daftar agar tidak berubah diam-diam saat disimpan.
    if ($current && !array_key_exists($current, $kategori)) {
        $kategori[$current] = ucfirst($current);
    }
@endphp

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow mb-4">
            <div class="card-body">
                <div class="mb-3">
                    <label for="title" class="form-label">Judul</label>
                    <input type="text" class="form-control form-control-lg @error('title') is-invalid @enderror" id="title"
                        name="title" value="{{ old('title', $post?->title) }}" maxlength="255" required>
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-1">
                    <label for="content" class="form-label" id="content-label">Isi</label>
                    <input id="content" type="hidden" name="content" value="{{ old('content', $post?->content) }}">
                    <trix-editor input="content" aria-labelledby="content-label"
                        @class(['form-control', 'app-trix', 'is-invalid' => $errors->has('content')])></trix-editor>
                    @error('content') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow mb-4">
            <div class="card-body">
                <div class="mb-3">
                    <label for="category" class="form-label">Kategori</label>
                    <select class="form-select @error('category') is-invalid @enderror" id="category" name="category">
                        @foreach ($kategori as $value => $label)
                            <option value="{{ $value }}" @selected($current === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <label for="image-source" class="form-label">Gambar sampul <span class="text-gray-500 fw-normal">(opsional)</span></label>
                <div class="app-image-drop mb-2" style="aspect-ratio: 16 / 9">
                    <img id="image-preview" alt="Pratinjau gambar sampul"
                        src="{{ $post?->gambar ? asset('storage/' . $post->gambar) : '' }}" @class(['d-none' => !$post?->gambar])>
                    <span id="image-empty" @class(['d-none' => $post?->gambar])><i class="fas fa-image" aria-hidden="true"></i>Belum ada gambar</span>
                </div>
                <input class="form-control @error('gambar') is-invalid @enderror" type="file" id="image-source" name="gambar"
                    accept="image/*" aria-describedby="gambarHelp">
                <div id="gambarHelp" class="form-text">JPG/PNG, maksimal 2,4 MB. Rasio 16:9 paling pas.</div>
                @error('gambar') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="d-grid gap-2 mb-4">
            <button type="submit" class="btn btn-gray-800">{{ $post ? 'Simpan perubahan' : 'Simpan & terbitkan' }}</button>
            <a href="{{ route('post.index') }}" class="btn btn-outline-gray-600">Batal</a>
        </div>
    </div>
</div>

@push('form-scripts')
    <script>
        // Tidak ada endpoint unggah lampiran: tolak file yang di-drop ke editor agar tidak hilang diam-diam.
        document.addEventListener('trix-file-accept', function (e) {
            e.preventDefault();
            alert('Lampiran di dalam isi belum didukung. Gunakan kolom "Gambar sampul".');
        });
        document.getElementById('image-source').addEventListener('change', function () {
            var file = this.files && this.files[0];
            if (!file) return;
            var reader = new FileReader();
            reader.onload = function (e) {
                var img = document.getElementById('image-preview');
                img.src = e.target.result;
                img.classList.remove('d-none');
                document.getElementById('image-empty').classList.add('d-none');
            };
            reader.readAsDataURL(file);
        });
    </script>
@endpush
