@extends('layouts.guest')

@section('title', 'Konfirmasi kata sandi')

@section('content')
    <h1 class="h4 mb-1">Konfirmasi kata sandi</h1>
    <p class="text-gray-500 mb-4">Demi keamanan, masukkan kembali kata sandi Anda sebelum melanjutkan.</p>

    <form method="POST" action="{{ route('password.confirm') }}" novalidate>
        @csrf
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-baseline">
                <label for="password" class="form-label">Kata sandi</label>
                @if (Route::has('password.request'))
                    <a class="small" href="{{ route('password.request') }}">Lupa kata sandi?</a>
                @endif
            </div>
            <input name="password" type="password" id="password"
                class="form-control @error('password') is-invalid @enderror" autocomplete="current-password" required autofocus>
            @error('password')
                <div class="invalid-feedback" role="alert">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-gray-800 w-100">Konfirmasi</button>
    </form>
@endsection
