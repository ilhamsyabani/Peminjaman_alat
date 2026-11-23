{{-- Form barang bersama (create & edit). Param: $product (nullable), $countries --}}
@php
    $product = $product ?? null;
    $status = old('status', $product?->status ?? 'tersedia');
    // Status peminjaman diatur oleh alur transaksi, bukan dari form ini.
    $statusDikunci = $product && !in_array($product->status, ['tersedia', 'kosong'], true);

    $locId = old('location_id', $product?->location_id);
    $roomId = old('room_id', $product?->room_id);
    $cabId = old('cabinet_id', $product?->locker_id);
    $rooms = $locId ? \App\Models\Room::where('location_id', $locId)->orderBy('name')->get(['id', 'name']) : collect();
    $cabinets = $roomId ? \App\Models\Cabinet::where('room_id', $roomId)->orderBy('name')->get(['id', 'name']) : collect();
@endphp

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow mb-4">
            <div class="card-body">
                <h2 class="h6 mb-3">Data barang</h2>
                <div class="row">
                    <div class="col-md-5 mb-3">
                        <label for="kode" class="form-label">Kode barang</label>
                        <input type="text" class="form-control @error('kode') is-invalid @enderror" id="kode" name="kode"
                            value="{{ old('kode', $product?->code) }}" aria-describedby="kodeHelp" required>
                        <div id="kodeHelp" class="form-text">Sesuai label yang tertempel di barang.</div>
                        @error('kode') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-7 mb-3">
                        <label for="name" class="form-label">Nama barang</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                            value="{{ old('name', $product?->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="info" class="form-label">Keterangan <span class="text-gray-500 fw-normal">(opsional)</span></label>
                    <textarea class="form-control @error('info') is-invalid @enderror" id="info" name="info" rows="3"
                        maxlength="225" aria-describedby="infoHelp">{{ old('info', $product?->info) }}</textarea>
                    <div id="infoHelp" class="form-text">Kelengkapan atau kondisi barang. Maksimal 225 karakter.</div>
                    @error('info') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-1">
                    <label for="status" class="form-label">Status</label>
                    @if ($statusDikunci)
                        <input type="hidden" name="status" value="{{ $product->status }}">
                        <div class="d-flex align-items-center gap-2">
                            @include('partials.status', ['status' => $product->status, 'type' => 'product'])
                            <span class="small text-gray-500">Diatur otomatis oleh transaksi peminjaman.</span>
                        </div>
                    @else
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                            <option value="tersedia" @selected($status === 'tersedia')>Tersedia — dapat dipinjam</option>
                            <option value="kosong" @selected($status === 'kosong')>Tidak tersedia — rusak/diperbaiki</option>
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    @endif
                </div>
            </div>
        </div>

        <div class="card border-0 shadow mb-4">
            <div class="card-body">
                <h2 class="h6 mb-3">Lokasi penyimpanan</h2>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="country-dropdown" class="form-label">Gedung</label>
                        <select class="form-select @error('location_id') is-invalid @enderror" id="country-dropdown" name="location_id" required>
                            <option value="">Pilih gedung</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}" @selected($locId == $country->id)>{{ $country->name }}</option>
                            @endforeach
                        </select>
                        @error('location_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="state-dropdown" class="form-label">Ruang</label>
                        <select class="form-select @error('room_id') is-invalid @enderror" id="state-dropdown" name="room_id" required>
                            <option value="">{{ $locId ? 'Pilih ruang' : 'Pilih gedung dulu' }}</option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}" @selected($roomId == $room->id)>{{ $room->name }}</option>
                            @endforeach
                        </select>
                        @error('room_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="city-dropdown" class="form-label">Lemari <span class="text-gray-500 fw-normal">(opsional)</span></label>
                        <select class="form-select @error('cabinet_id') is-invalid @enderror" id="city-dropdown" name="cabinet_id">
                            <option value="">Tanpa lemari</option>
                            @foreach ($cabinets as $cab)
                                <option value="{{ $cab->id }}" @selected($cabId == $cab->id)>{{ $cab->name }}</option>
                            @endforeach
                        </select>
                        @error('cabinet_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <a href="{{ route('location') }}" class="small" target="_blank" rel="noopener">
                    Gedung/ruang belum ada? Kelola lokasi <i class="fas fa-external-link-alt ms-1" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow mb-4">
            <div class="card-body">
                <h2 class="h6 mb-3">Foto barang</h2>
                <div class="app-image-drop mb-3">
                    <img id="image-preview" alt="Pratinjau foto barang"
                        src="{{ $product?->image ? asset('storage/' . $product->image) : '' }}"
                        @class(['d-none' => !$product?->image])>
                    <span id="image-empty" @class(['d-none' => $product?->image])>
                        <i class="fas fa-image" aria-hidden="true"></i>Belum ada foto
                    </span>
                </div>
                <input class="form-control @error('image') is-invalid @enderror" type="file" id="image-source" name="image"
                    accept="image/*" aria-describedby="imageHelp">
                <div id="imageHelp" class="form-text">JPG/PNG, maksimal 2 MB.</div>
                @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="d-grid gap-2 mb-4">
            <button type="submit" class="btn btn-gray-800">Simpan</button>
            <a href="{{ route('products.index') }}" class="btn btn-outline-gray-600">Batal</a>
        </div>
    </div>
</div>

@push('form-scripts')
    <script>
        $(function () {
            var token = '{{ csrf_token() }}';
            function fill($select, items, placeholder) {
                $select.empty().append($('<option>', { value: '', text: placeholder }));
                $.each(items, function (_, item) { $select.append($('<option>', { value: item.id, text: item.name })); });
            }
            $('#country-dropdown').on('change', function () {
                fill($('#city-dropdown'), [], 'Tanpa lemari');
                if (!this.value) { fill($('#state-dropdown'), [], 'Pilih gedung dulu'); return; }
                $.post("{{ url('get-states-by-country') }}", { country_id: this.value, _token: token }, function (r) {
                    fill($('#state-dropdown'), r.states, r.states.length ? 'Pilih ruang' : 'Belum ada ruang di gedung ini');
                }, 'json');
            });
            $('#state-dropdown').on('change', function () {
                if (!this.value) { fill($('#city-dropdown'), [], 'Tanpa lemari'); return; }
                $.post("{{ url('get-cities-by-state') }}", { state_id: this.value, _token: token }, function (r) {
                    fill($('#city-dropdown'), r.cities, 'Tanpa lemari');
                }, 'json');
            });
            $('#image-source').on('change', function () {
                var file = this.files && this.files[0];
                if (!file) return;
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#image-preview').attr('src', e.target.result).removeClass('d-none');
                    $('#image-empty').addClass('d-none');
                };
                reader.readAsDataURL(file);
            });
        });
    </script>
@endpush
