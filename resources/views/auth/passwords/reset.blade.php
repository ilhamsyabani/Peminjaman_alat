@extends('layouts.guest')

@section('title', 'Buat kata sandi baru')

@section('content')
    <h1 class="h4 mb-1">Buat kata sandi baru</h1>
    <p class="text-gray-500 mb-4">Minimal 8 karakter. Setelah disimpan Anda akan langsung masuk.</p>

    <form method="POST" action="{{ route('password.update') }}" novalidate>
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input name="email" type="email" id="email" value="{{ old('email', $email ?? request('email')) }}"
                class="form-control @error('email') is-invalid @enderror" autocomplete="username" required>
            @error('email')
                <div class="invalid-feedback" role="alert">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Kata sandi baru</label>
            <input name="password" type="password" id="password"
                class="form-control @error('password') is-invalid @enderror" autocomplete="new-password" required autofocus>
            @error('password')
                <div class="invalid-feedback" role="alert">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-4">
            <label for="password_confirmation" class="form-label">Ulangi kata sandi baru</label>
            <input name="password_confirmation" type="password" id="password_confirmation" class="form-control"
                autocomplete="new-password" required>
        </div>
        <button type="submit" class="btn btn-gray-800 w-100">Simpan kata sandi</button>
    </form>
@endsection
