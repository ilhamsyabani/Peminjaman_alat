@extends('layouts.app')

@section('title', 'Informasi')

@section('content')
    @include('partials.page-header', ['title' => 'Informasi', 'crumbs' => [['Informasi', null]], 'subtitle' => 'Kabar dan pengumuman yang tampil di halaman publik.', 'action' => [route('post.create'), 'Tulis informasi', 'fa-pen']])
    <div class="card card-body border-0 shadow">
        @include('partials.list-toolbar', ['placeholder' => 'Cari judul informasi'])

        <div class="table-wrapper">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th class="d-none d-md-table-cell">Kategori</th>
                        <th class="d-none d-lg-table-cell">Penulis</th>
                        <th class="d-none d-md-table-cell">Diperbarui</th>
                        <th class="text-end"><span class="visually-hidden">Aksi</span></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($posts as $post)
                        <tr>
                            <td>
                                <span class="fw-bold text-gray-900 d-block">{{ $post->title }}</span>
                                <a href="{{ route('blog.post', $post) }}" target="_blank" rel="noopener" class="small text-gray-500">
                                    Lihat di situs <i class="fas fa-external-link-alt ms-1" aria-hidden="true"></i></a>
                            </td>
                            <td class="d-none d-md-table-cell"><span class="app-badge app-badge--neutral">{{ ucfirst($post->category) }}</span></td>
                            <td class="d-none d-lg-table-cell small">{{ $post->user?->name ?? '—' }}</td>
                            <td class="d-none d-md-table-cell small text-gray-600 text-nowrap">{{ $post->updated_at?->locale('id')->translatedFormat('j M Y') }}</td>
                            <td>
                                <div class="app-actions">
                                    <a class="app-icon-btn" href="{{ route('post.edit', $post) }}" title="Ubah" aria-label="Ubah {{ $post->title }}">
                                        <i class="fas fa-pen" aria-hidden="true"></i>
                                    </a>
                                    <form action="{{ route('post.destroy', $post) }}" method="post">
                                        @method('delete')
                                        @csrf
                                        <button class="app-icon-btn app-icon-btn--danger" title="Hapus" aria-label="Hapus {{ $post->title }}"
                                            onclick="return confirm('Hapus informasi ini?')">
                                            <i class="fas fa-trash-alt" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="app-empty">
                                <i class="fas fa-newspaper" aria-hidden="true"></i>
                                {{ request('search') ? 'Tidak ada data yang cocok dengan pencarian.' : 'Belum ada informasi.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @include('partials.list-footer', ['paginator' => $posts])
    </div>
@endsection
