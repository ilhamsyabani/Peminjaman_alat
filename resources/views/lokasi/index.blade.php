@extends('layouts.app')

@section('title', 'Lokasi')

@section('content')
    @include('partials.page-header', [
        'title' => 'Lokasi',
        'subtitle' => 'Gedung, ruang, dan lemari tempat barang disimpan.',
        'crumbs' => [['Lokasi', null]],
    ])

    @php
        $locations = \App\Models\Location::orderBy('name')->get();
        $roomsByLoc = \App\Models\Room::orderBy('name')->get()->groupBy('location_id');
        $cabsByRoom = \App\Models\Cabinet::orderBy('name')->get()->groupBy('room_id');
        $productCount = \App\Models\Product::selectRaw('room_id, count(*) as n')->groupBy('room_id')->pluck('n', 'room_id');
    @endphp

    @if ($errors->any())
        <div class="alert alert-danger d-flex align-items-center" role="alert">
            <i class="fas fa-exclamation-circle me-2" aria-hidden="true"></i>
            Data belum tersimpan: {{ $errors->first() }}
        </div>
    @endif

    <div class="d-flex flex-wrap gap-2 mb-4">
        <button type="button" class="btn btn-gray-800" data-bs-toggle="modal" data-bs-target="#modal1">
            <i class="fas fa-building me-1" aria-hidden="true"></i> Tambah gedung
        </button>
        <button type="button" class="btn btn-outline-gray-600" data-bs-toggle="modal" data-bs-target="#modalRuang" @disabled($locations->isEmpty())>
            <i class="fas fa-door-open me-1" aria-hidden="true"></i> Tambah ruang
        </button>
        <button type="button" class="btn btn-outline-gray-600" data-bs-toggle="modal" data-bs-target="#modalLemari" @disabled($roomsByLoc->isEmpty())>
            <i class="fas fa-archive me-1" aria-hidden="true"></i> Tambah lemari
        </button>
    </div>

    @forelse ($locations as $location)
        @php($rooms = $roomsByLoc->get($location->id, collect()))
        <div class="card border-0 shadow mb-3">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h2 class="h6 mb-0"><i class="fas fa-building text-gray-400 me-2" aria-hidden="true"></i>{{ $location->name }}</h2>
                <span class="small text-gray-500">{{ $rooms->count() }} ruang</span>
            </div>
            <div class="card-body py-2">
                @forelse ($rooms as $room)
                    @php($cabs = $cabsByRoom->get($room->id, collect()))
                    <div class="app-tree-row">
                        <div class="min-w-0">
                            <div class="fw-bold text-gray-900">
                                <i class="fas fa-door-open text-gray-400 me-2" aria-hidden="true"></i>{{ $room->name }}
                            </div>
                            <div class="small text-gray-500 ms-4 mt-1">
                                @if ($cabs->isEmpty())
                                    Tanpa lemari
                                @else
                                    @foreach ($cabs as $cab)
                                        <span class="app-chip"><i class="fas fa-archive me-1" aria-hidden="true"></i>{{ $cab->name }}</span>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <span class="small text-gray-500 text-nowrap">{{ $productCount->get($room->id, 0) }} barang</span>
                    </div>
                @empty
                    <p class="text-gray-500 small my-2">Belum ada ruang di gedung ini.</p>
                @endforelse
            </div>
        </div>
    @empty
        <div class="card border-0 shadow">
            <div class="app-empty">
                <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                Belum ada lokasi. Mulai dengan menambahkan gedung.
            </div>
        </div>
    @endforelse

    {{-- Modal: gedung --}}
    <div class="modal fade" id="modal1" tabindex="-1" aria-labelledby="modal1Label" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('simpan.lokasi') }}" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modal1Label">Tambah gedung</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <label for="lokasi-name" class="form-label">Nama gedung</label>
                    <input type="text" name="name" class="form-control" id="lokasi-name" placeholder="Contoh: Gedung Fakultas Teknik" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-gray-600" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-gray-800">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal: ruang --}}
    <div class="modal fade" id="modalRuang" tabindex="-1" aria-labelledby="modalRuangLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('simpan.ruang') }}" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalRuangLabel">Tambah ruang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="ruang-location" class="form-label">Gedung</label>
                        <select class="form-select" id="ruang-location" name="location_id" required>
                            @foreach ($locations as $location)
                                <option value="{{ $location->id }}">{{ $location->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <label for="ruang-name" class="form-label">Nama ruang</label>
                    <input type="text" name="name" class="form-control" id="ruang-name" placeholder="Contoh: Laboratorium Multimedia" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-gray-600" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-gray-800">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal: lemari --}}
    <div class="modal fade" id="modalLemari" tabindex="-1" aria-labelledby="modalLemariLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('simpan.lemari') }}" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLemariLabel">Tambah lemari</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="lemari-room" class="form-label">Ruang</label>
                        <select class="form-select" id="lemari-room" name="room_id" required>
                            @foreach ($locations as $location)
                                @if ($roomsByLoc->has($location->id))
                                    <optgroup label="{{ $location->name }}">
                                        @foreach ($roomsByLoc->get($location->id) as $room)
                                            <option value="{{ $room->id }}">{{ $room->name }}</option>
                                        @endforeach
                                    </optgroup>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <label for="lemari-name" class="form-label">Nama lemari / tempat penyimpanan</label>
                    <input type="text" name="name" class="form-control" id="lemari-name" placeholder="Contoh: Lemari C1" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-gray-600" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-gray-800">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
