@extends('layouts.app')

@section('content')
    <div class="main py-4">
        <div class="card card-body border-0 shadow table-wrapper table-responsive">
            <h2 class="mb-4 h5">{{ __('Admin') }}</h2>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="border-gray-200">{{ __('Name') }}</th>
                        <th class="border-gray-200">{{ __('Email') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td><span class="fw-normal">{{ $user->name }}</span></td>
                            <td><span class="fw-normal">{{ $user->email }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div
                class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
                {{ $users->links() }}
            </div>
            <div class="btn-toolbar mb-2 mb-md-0">
                <a href="{{ route('daftar') }}"
                    class="btn btn-sm btn-gray-800 d-inline-flex align-items-center keychainify-checked">
                    <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                        </path>
                    </svg>
                    Tambah Admin
                </a>
            </div>
        </div>
    </div>
@endsection
