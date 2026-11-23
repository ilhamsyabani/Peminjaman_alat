{{-- Form member bersama (create & edit). Param: $member (nullable) --}}
@php($member = $member ?? null)

<div class="row">
    <div class="col-lg-5 order-lg-2">
        <div class="card border-0 shadow mb-4">
            <div class="card-body">
                <h2 class="h6 mb-1">Foto member</h2>
                <p class="small text-gray-500 mb-3">
                    {{ $member ? 'Ambil foto baru bila ingin mengganti foto saat ini.' : 'Wajib. Arahkan kamera ke wajah member lalu ambil foto.' }}
                </p>

                <div class="app-camera mb-3">
                    <div id="my_camera" aria-label="Pratinjau kamera"></div>
                    <img id="photo-result" alt="Foto yang diambil" class="d-none">
                    <div id="camera-status" class="app-camera__status d-none" role="status"></div>
                </div>

                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-gray-800 flex-grow-1" id="btn-snap">
                        <i class="fas fa-camera me-1" aria-hidden="true"></i> Ambil foto
                    </button>
                    <button type="button" class="btn btn-outline-gray-600 d-none" id="btn-retake">Ulangi</button>
                </div>

                <input type="hidden" name="photo" class="image-tag" value="{{ old('photo', $member?->photo) }}">
                @error('photo')
                    <div class="text-danger small mt-2" role="alert">{{ $message }}</div>
                @enderror

                @if ($member)
                    <div class="d-flex align-items-center gap-2 mt-3 small text-gray-500">
                        @include('partials.avatar', ['name' => $member->name, 'photo' => $member->photo, 'size' => 32])
                        Foto saat ini
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-7 order-lg-1">
        <div class="card border-0 shadow mb-4">
            <div class="card-body">
                <h2 class="h6 mb-3">Data member</h2>
                <div class="mb-3">
                    <label for="name" class="form-label">Nama lengkap</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                        value="{{ old('name', $member?->name) }}" autocomplete="off" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="identity_number" class="form-label">Nomor identitas</label>
                        <input type="text" class="form-control @error('identity_number') is-invalid @enderror" id="identity_number"
                            name="identity_number" value="{{ old('identity_number', $member?->identity_number) }}"
                            aria-describedby="idHelp" inputmode="numeric" required>
                        <div id="idHelp" class="form-text">NIM, NIP, atau NIK.</div>
                        @error('identity_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="hp" class="form-label">No. HP</label>
                        <input type="tel" class="form-control @error('hp') is-invalid @enderror" id="hp" name="hp"
                            value="{{ old('hp', $member?->hp) }}" placeholder="08…" required>
                        @error('hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                        value="{{ old('email', $member?->email) }}" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Alamat</label>
                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3"
                        required>{{ old('address', $member?->address) }}</textarea>
                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-1">
                    <label for="info" class="form-label">Keterangan <span class="text-gray-500 fw-normal">(opsional)</span></label>
                    <textarea class="form-control @error('info') is-invalid @enderror" id="info" name="info" rows="2"
                        placeholder="Contoh: Mahasiswa Teknologi Pendidikan angkatan 2023">{{ old('info', $member?->info) }}</textarea>
                    @error('info') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                @unless ($member)
                    <input type="hidden" name="status" value="tidak_ada">
                    @error('status') <div class="text-danger small mt-2" role="alert">{{ $message }}</div> @enderror
                @endunless
            </div>
            <div class="card-footer bg-white d-flex justify-content-end gap-2">
                <a href="{{ $member ? route('members.show', $member) : route('members.index') }}" class="btn btn-outline-gray-600">Batal</a>
                <button type="submit" class="btn btn-gray-800">Simpan</button>
            </div>
        </div>
    </div>
</div>

@push('form-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <script>
        $(function () {
            var $status = $('#camera-status');
            function showStatus(msg) { $status.text(msg).removeClass('d-none'); }

            if (!window.Webcam) {
                showStatus('Modul kamera gagal dimuat. Periksa koneksi internet lalu muat ulang halaman.');
                $('#btn-snap').prop('disabled', true);
                return;
            }

            function showPhoto(dataUri) {
                $('#photo-result').attr('src', dataUri).removeClass('d-none');
                $('#my_camera').addClass('d-none');
                $('#btn-snap').addClass('d-none');
                $('#btn-retake').removeClass('d-none');
            }
            // Setelah validasi gagal, foto yang sudah diambil tetap dipakai.
            var existing = $('.image-tag').val() || '';
            if (existing.indexOf('data:image/') === 0) { showPhoto(existing); }

            Webcam.set({ width: 480, height: 360, image_format: 'jpeg', jpeg_quality: 90 });
            Webcam.on('error', function () {
                showStatus('Kamera tidak dapat diakses. Izinkan akses kamera di browser, lalu muat ulang halaman.');
                $('#btn-snap').prop('disabled', true);
            });
            Webcam.attach('#my_camera');

            $('#btn-snap').on('click', function () {
                Webcam.snap(function (dataUri) {
                    $('.image-tag').val(dataUri);
                    showPhoto(dataUri);
                });
            });
            $('#btn-retake').on('click', function () {
                $('.image-tag').val(@json($member?->photo ?? ''));
                $('#photo-result').addClass('d-none');
                $('#my_camera').removeClass('d-none');
                $('#btn-snap').removeClass('d-none');
                $(this).addClass('d-none');
            });
        });
    </script>
@endpush
