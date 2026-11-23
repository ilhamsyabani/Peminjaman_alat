@extends('layouts.guest')

@section('title', 'Masuk')

@section('content')
    <h1 class="h4 mb-1">Masuk</h1>
    <p class="text-gray-500 mb-4">Khusus petugas LAP TP untuk mengelola peminjaman.</p>

    <form action="{{ route('login') }}" method="POST" novalidate>
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input name="email" type="email" id="email" value="{{ old('email') }}"
                class="form-control @error('email') is-invalid @enderror" autocomplete="username" required autofocus>
            @error('email')
                <div class="invalid-feedback" role="alert">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-baseline">
                <label for="password" class="form-label">Kata sandi</label>
                <a href="{{ route('password.request') }}" class="small">Lupa kata sandi?</a>
            </div>
            <input name="password" type="password" id="password"
                class="form-control @error('password') is-invalid @enderror" autocomplete="current-password" required>
            @error('password')
                <div class="invalid-feedback" role="alert">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" name="remember" id="remember" @checked(old('remember'))>
            <label class="form-check-label" for="remember">Ingat saya di perangkat ini</label>
        </div>
        <button type="submit" class="btn btn-gray-800 w-100">Masuk</button>
    </form>

    <p class="text-center small text-gray-500 mt-4 mb-0">
        <a href="{{ url('/') }}"><i class="fas fa-arrow-left me-1" aria-hidden="true"></i>Kembali ke beranda</a>
    </p>
@endsection
