<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('description', 'Layanan peminjaman barang dan fasilitas Laboratorium Teknologi Pendidikan FIP UNY.')">

    <title>@yield('title', 'Pinjam di LAP') · LAP TP FIP UNY</title>
    @include('partials.favicon')

    <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/landing.css') }}">
</head>

<body class="lp">
    <a class="lp-skip" href="#konten">Lewati ke konten</a>

    @include('blog.header')

    <div id="konten">
        @yield('content')
    </div>

    @include('blog.footer')
</body>

</html>
