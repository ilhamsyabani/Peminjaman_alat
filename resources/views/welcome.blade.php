@extends('blog.layout')

@section('title', 'Peminjaman Barang & Fasilitas')

@php
    $kategoriIkon = [
        'panduan' => 'fa-book-open',
        'pengumuman' => 'fa-bullhorn',
        'berita' => 'fa-newspaper',
        'kegiatan' => 'fa-calendar-alt',
        'info' => 'fa-info-circle',
    ];
@endphp

@section('content')
    <main>
        {{-- Hero --}}
        <section class="lp-hero">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <p class="lp-eyebrow">Laboratorium Teknologi Pendidikan FIP UNY</p>
                        <h1 class="lp-hero__title">Pinjam alat dan fasilitas lab tanpa ribet.</h1>
                        <p class="lp-hero__lead">
                            Ajukan peminjaman kamera, proyektor, laptop, dan perlengkapan lain langsung ke petugas LAP TP.
                            Status pinjaman dan pengembalian tercatat rapi di satu tempat.
                        </p>
                        <div class="lp-hero__actions">
                            @auth
                                <a href="{{ route('transactions.create') }}" class="lp-btn lp-btn--accent">
                                    Buka dashboard <i class="fas fa-arrow-right" aria-hidden="true"></i>
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="lp-btn lp-btn--accent">
                                    Masuk untuk petugas <i class="fas fa-arrow-right" aria-hidden="true"></i>
                                </a>
                            @endauth
                            <a href="#alur" class="lp-btn lp-btn--ghost">Lihat cara meminjam</a>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="lp-steps" id="alur">
                            <p class="lp-steps__label">Cara meminjam</p>
                            <ol>
                                <li>
                                    <span class="lp-steps__num">1</span>
                                    <div>
                                        <strong>Datang ke LAP TP</strong>
                                        <p>Sampaikan barang yang ingin dipinjam kepada petugas.</p>
                                    </div>
                                </li>
                                <li>
                                    <span class="lp-steps__num">2</span>
                                    <div>
                                        <strong>Serahkan kartu identitas</strong>
                                        <p>KTM atau KTP disimpan sebagai jaminan selama peminjaman.</p>
                                    </div>
                                </li>
                                <li>
                                    <span class="lp-steps__num">3</span>
                                    <div>
                                        <strong>Petugas mencatat &amp; menyetujui</strong>
                                        <p>Barang dicatat atas nama Anda dan siap dibawa.</p>
                                    </div>
                                </li>
                                <li>
                                    <span class="lp-steps__num">4</span>
                                    <div>
                                        <strong>Kembalikan tepat waktu</strong>
                                        <p>Jaminan dikembalikan setelah semua barang diperiksa.</p>
                                    </div>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Layanan --}}
        <section class="lp-section" id="layanan">
            <div class="container">
                <p class="lp-eyebrow">Layanan</p>
                <h2 class="lp-section__title">Yang bisa Anda dapatkan di LAP TP</h2>
                <div class="row">
                    @foreach ([
                        ['fa-camera', 'Peminjaman barang', 'Kamera, proyektor, laptop, audio, dan perlengkapan produksi media.'],
                        ['fa-door-open', 'Reservasi ruangan', 'Ruang rapat, studio, dan laboratorium untuk kegiatan akademik.'],
                        ['fa-user-graduate', 'Konsultasi tugas akhir', 'Pendampingan pemanfaatan teknologi untuk skripsi dan penelitian.'],
                        ['fa-chalkboard-teacher', 'Pelatihan teknologi', 'Pelatihan pemanfaatan dan pengembangan teknologi pembelajaran.'],
                    ] as [$ikon, $judul, $deskripsi])
                        <div class="col-sm-6 col-lg-3 d-flex">
                            <article class="lp-card lp-service">
                                <span class="lp-service__icon"><i class="fas {{ $ikon }}" aria-hidden="true"></i></span>
                                <h3>{{ $judul }}</h3>
                                <p>{{ $deskripsi }}</p>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Informasi / blog --}}
        <section class="lp-section lp-section--muted" id="informasi">
            <div class="container">
                <p class="lp-eyebrow">Informasi</p>
                <h2 class="lp-section__title">Kabar terbaru seputar LAP TP FIP UNY</h2>

                @if ($posts->isEmpty())
                    <div class="lp-empty">
                        <i class="far fa-newspaper" aria-hidden="true"></i>
                        <p>Belum ada informasi yang diterbitkan.</p>
                    </div>
                @else
                    <div class="row">
                        @foreach ($posts as $post)
                            <div class="col-md-6 col-lg-4 d-flex">
                                <article class="lp-card lp-post">
                                    <a href="{{ route('blog.post', $post) }}" class="lp-post__media" tabindex="-1" aria-hidden="true">
                                        @if ($post->gambar)
                                            <img src="{{ asset('storage/' . $post->gambar) }}" alt="" loading="lazy">
                                        @else
                                            <span class="lp-post__placeholder">
                                                <i class="fas {{ $kategoriIkon[strtolower($post->category)] ?? 'fa-file-alt' }}"></i>
                                            </span>
                                        @endif
                                    </a>
                                    <div class="lp-post__body">
                                        <p class="lp-post__meta">
                                            <span class="lp-badge">{{ ucfirst($post->category) }}</span>
                                            <time datetime="{{ $post->created_at?->toDateString() }}">
                                                {{ $post->created_at?->locale('id')->translatedFormat('j F Y') }}
                                            </time>
                                        </p>
                                        <h3 class="lp-post__title">
                                            <a href="{{ route('blog.post', $post) }}">{{ $post->title }}</a>
                                        </h3>
                                        <p class="lp-post__excerpt">{{ $post->excerpt }}</p>
                                        <a href="{{ route('blog.post', $post) }}" class="lp-link">
                                            Baca selengkapnya <i class="fas fa-arrow-right" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>

                    @if ($posts->hasPages())
                        <nav class="lp-pagination" aria-label="Halaman informasi">
                            {{ $posts->fragment('informasi')->links('pagination::bootstrap-4') }}
                        </nav>
                    @endif
                @endif
            </div>
        </section>
    </main>
@endsection
