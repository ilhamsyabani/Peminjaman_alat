@extends('layouts.guest')

@section('title', 'Lupa kata sandi')

@section('content')
    <h1 class="h4 mb-1">Lupa kata sandi?</h1>
    <p class="text-gray-500 mb-4">Masukkan email akun Anda. Kami akan mengirim tautan untuk membuat kata sandi baru.</p>

    @if (session('status'))
        <div class="alert alert-success d-flex align-items-center" role="status">
            <i class="fas fa-check-circle me-2" aria-hidden="true"></i>{{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" novalidate>
        @csrf
        <div class="mb-4">
            <label for="email" class="form-label">Email</label>
            <input name="email" type="email" id="email" value="{{ old('email') }}"
                class="form-control @error('email') is-invalid @enderror" autocomplete="email" required autofocus>
            @error('email')
                <div class="invalid-feedback" role="alert">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-gray-800 w-100">Kirim tautan reset</button>
    </form>

    <p class="text-center small mt-4 mb-0">
        <a href="{{ route('login') }}"><i class="fas fa-arrow-left me-1" aria-hidden="true"></i>Kembali ke halaman masuk</a>
    </p>
@endsection
