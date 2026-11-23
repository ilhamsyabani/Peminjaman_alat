@extends('layouts.app')

@section('title', 'Tentang aplikasi')

@section('content')
    @include('partials.page-header', [
        'title' => 'Tentang Pinjam di LAP',
        'subtitle' => 'Sistem pencatatan peminjaman barang Laboratorium Teknologi Pendidikan FIP UNY.',
        'crumbs' => [['Tentang', null]],
    ])

    <div class="row">
        <div class="col-xl-8">
            <div class="card border-0 shadow mb-4">
                <div class="card-body">
                    <h2 class="h6 mb-3">Alur peminjaman</h2>
                    <ol class="mb-0 ps-3">
                        <li class="mb-2"><strong>Dashboard</strong> — cari dan pilih member, lalu tambahkan barang yang tersedia.</li>
                        <li class="mb-2"><strong>Ajukan pinjaman</strong> — periksa daftar barang, terima kartu jaminan (KTM/KTP), lalu setujui.</li>
                        <li class="mb-2"><strong>Peminjaman</strong> — pantau pinjaman aktif. Kembalikan barang satu per satu dari halaman detail, atau selesaikan sekaligus.</li>
                        <li><strong>Laporan</strong> — lihat riwayat per transaksi, per member, atau per barang.</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection
