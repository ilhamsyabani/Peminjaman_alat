<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Pinjam di LAP') · LAP TP FIP UNY</title>
    @include('partials.favicon')

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body class="app-auth">
    <main class="app-auth__main">
        <a href="{{ url('/') }}" class="app-auth__brand">
            <img src="{{ asset('favicon.svg') }}" width="40" height="40" alt="">
            <span>Pinjam di LAP</span>
        </a>

        <div class="app-auth__card">
            @yield('content')
        </div>

        <p class="app-auth__foot">Laboratorium Teknologi Pendidikan · FIP UNY</p>
    </main>
</body>

</html>
