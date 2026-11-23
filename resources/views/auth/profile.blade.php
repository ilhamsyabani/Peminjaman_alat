@extends('layouts.app')

@section('title', 'Profil saya')

@section('content')
    @include('partials.page-header', [
        'title' => 'Profil saya',
        'subtitle' => 'Ubah nama, email, atau kata sandi akun Anda.',
        'crumbs' => [['Profil', null]],
    ])

    <div class="row">
        <div class="col-xl-8">
            <form action="{{ route('profile.update') }}" method="POST" class="card border-0 shadow mb-4" novalidate>
                @csrf
                @method('PUT')
                <div class="card-body">
                    <h2 class="h6 mb-3">Data akun</h2>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input id="name" class="form-control @error('name') is-invalid @enderror" type="text" name="name"
                                value="{{ old('name', auth()->user()->name) }}" required autocomplete="name">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email"
                                value="{{ old('email', auth()->user()->email) }}" required autocomplete="email">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <h2 class="h6 mt-2 mb-1">Ganti kata sandi</h2>
                    <p class="small text-gray-500 mb-3">Kosongkan bila tidak ingin mengganti. Minimal 8 karakter.</p>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Kata sandi baru</label>
                            <input id="password" class="form-control @error('password') is-invalid @enderror" type="password"
                                name="password" autocomplete="new-password">
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">Ulangi kata sandi baru</label>
                            <input id="password_confirmation" class="form-control" type="password"
                                name="password_confirmation" autocomplete="new-password">
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white text-end">
                    <button type="submit" class="btn btn-gray-800">Simpan perubahan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
