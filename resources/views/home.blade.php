@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    @include('partials.page-header', [
        'title' => 'Dashboard',
        'subtitle' => 'Catat peminjaman baru dalam tiga langkah: pilih member, pilih barang, lalu ajukan.',
    ])

    {{-- Statistik --}}
    <div class="row">
        @foreach ([
            ['Member terdaftar', $data['user'], 'fa-id-card', '#eff6ff', '#1d4ed8', route('members.index')],
            ['Peminjaman aktif', $data['peminjaman'], 'fa-exchange-alt', '#fffbeb', '#b45309', route('transactions.index')],
            ['Total transaksi', $data['transaksi'], 'fa-file-alt', '#f5f3ff', '#6d28d9', route('report.transaction')],
            ['Jumlah barang', $data['barang'], 'fa-box', '#ecfdf5', '#047857', route('products.index')],
        ] as [$label, $value, $icon, $bg, $fg, $url])
            <div class="col-6 col-xl-3 mb-4">
                <a href="{{ $url }}" class="card border-0 shadow h-100 text-decoration-none">
                    <div class="card-body app-stat">
                        <span class="app-stat__icon" style="background: {{ $bg }}; color: {{ $fg }}">
                            <i class="fas {{ $icon }}" aria-hidden="true"></i>
                        </span>
                        <div>
                            <p class="app-stat__label">{{ $label }}</p>
                            <p class="app-stat__value">{{ number_format($value, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <div class="row">
        {{-- Langkah 1: member --}}
        <div class="col-lg-7 mb-4">
            <div class="card border-0 shadow h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h2 class="h6 mb-0"><span class="app-step">1</span> Pilih member</h2>
                    <a class="btn btn-sm btn-outline-gray-600" href="{{ route('members.create') }}">
                        <i class="fas fa-user-plus me-1" aria-hidden="true"></i> Member baru
                    </a>
                </div>
                <div class="card-body">
                    @if ($member)
                        <div class="app-selected">
                            @include('partials.avatar', ['name' => $member->name, 'photo' => $member->photo, 'size' => 56])
                            <div class="flex-grow-1 min-w-0">
                                <h6 class="mb-1">{{ $member->name }}</h6>
                                <div class="small text-gray-600">{{ $member->identity_number }} · {{ $member->hp }}</div>
                                <div class="small text-gray-500 text-truncate">{{ $member->email }} · {{ $member->address }}</div>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap gap-2 mt-3">
                            <button type="button" class="btn btn-gray-800" data-bs-toggle="modal" data-bs-target="#modalProduct">
                                <i class="fas fa-plus me-1" aria-hidden="true"></i> Tambah barang
                            </button>
                            <form action="{{ url('/processmember') }}" method="POST">
                                @csrf
                                <input type="hidden" value="{{ $member->id }}" name="id">
                                <input type="hidden" value="tidak_ada" name="status">
                                <button class="btn btn-outline-danger">Batalkan</button>
                            </form>
                        </div>
                    @else
                        <label for="searchmember" class="form-label">Cari berdasarkan nama atau nomor identitas</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-search" aria-hidden="true"></i></span>
                            <input type="search" class="form-control" placeholder="Contoh: Andi atau 3273…"
                                name="search" id="searchmember" autocomplete="off" autofocus>
                        </div>
                        <ul class="list-unstyled mb-0" id="search-results" aria-live="polite">
                            <li class="app-hint">Ketik minimal satu huruf untuk mencari member.</li>
                        </ul>
                    @endif
                </div>
            </div>
        </div>

        {{-- Langkah 2 & 3: barang --}}
        <div class="col-lg-5 mb-4">
            <div class="card border-0 shadow h-100">
                <div class="card-header bg-white">
                    <h2 class="h6 mb-0"><span class="app-step">2</span> Barang dipinjam</h2>
                </div>
                <div class="card-body d-flex flex-column">
                    <form method="post" action="{{ route('transactions.store') }}" class="d-flex flex-column flex-grow-1">
                        @csrf
                        @forelse ($products as $product)
                            <label class="app-pick">
                                <input type="checkbox" class="form-check-input mt-0" name="products[]" value="{{ $product->id }}" checked>
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="" class="app-thumb">
                                @else
                                    <span class="app-thumb"><i class="fas fa-box" aria-hidden="true"></i></span>
                                @endif
                                <span class="min-w-0">
                                    <span class="d-block fw-bold text-gray-900">{{ $product->name }}</span>
                                    <span class="d-block small text-gray-500 text-truncate">
                                        {{ $product->code }} · {{ $product->room?->name }}{{ $product->cabinet ? ', ' . $product->cabinet->name : '' }}
                                    </span>
                                </span>
                            </label>
                        @empty
                            <div class="app-hint">
                                {{ $member ? 'Klik “Tambah barang” untuk memilih barang yang akan dipinjam.' : 'Pilih member terlebih dahulu.' }}
                            </div>
                        @endforelse

                        <div class="mt-auto pt-3">
                            @if ($member)
                                <input type="hidden" name="member_id" value="{{ $member->id }}">
                            @endif
                            <button class="btn btn-primary w-100" type="submit" @disabled(!$member || $products->isEmpty())>
                                <span class="app-step app-step--light">3</span> Ajukan pinjaman
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalProduct" tabindex="-1" aria-labelledby="modalProductLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalProductLabel">Tambahkan barang pinjaman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <label for="searchproduct" class="form-label">Cari barang yang tersedia</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fas fa-search" aria-hidden="true"></i></span>
                        <input type="search" class="form-control" placeholder="Nama atau kode barang"
                            name="search" id="searchproduct" autocomplete="off">
                    </div>
                    <ul class="list-unstyled mb-0" id="results-product" aria-live="polite">
                        <li class="app-hint">Ketik nama atau kode barang.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        (function () {
            function liveSearch(input, target, url, hint) {
                var timer, last = null;
                function run() {
                    var q = $(input).val().trim();
                    if (q === last) return;
                    last = q;
                    if (q === '') { $(target).html('<li class="app-hint">' + hint + '</li>'); return; }
                    $(target).html('<li class="app-hint">Mencari…</li>');
                    $.get(url, { search: q }).done(function (data) {
                        if (q !== last) return; // abaikan respons yang sudah usang
                        var empty = typeof data === 'object' || !$.trim(data);
                        $(target).html(empty ? '<li class="app-hint">Tidak ada hasil untuk pencarian ini.</li>' : data);
                    }).fail(function () {
                        $(target).html('<li class="app-hint text-danger">Gagal memuat hasil. Coba lagi.</li>');
                    });
                }
                $(document).on('input keyup', input, function () { clearTimeout(timer); timer = setTimeout(run, 250); });
            }

            $(function () {
                liveSearch('#searchmember', '#search-results', "{{ url('/search-member') }}", 'Ketik minimal satu huruf untuk mencari member.');
                liveSearch('#searchproduct', '#results-product', "{{ url('/search-product') }}", 'Ketik nama atau kode barang.');
                $('#modalProduct').on('shown.bs.modal', function () { $('#searchproduct').trigger('focus'); });
            });
        })();
    </script>
@endsection
