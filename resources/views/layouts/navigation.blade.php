@php
    $menu = [
        ['transactions.create', 'fa-th-large', 'Dashboard', ['transactions.create']],
        ['transactions.index', 'fa-exchange-alt', 'Peminjaman', ['transactions.index', 'transactions.view']],
        ['products.index', 'fa-box', 'Barang', ['products.*']],
        ['members.index', 'fa-id-card', 'Member', ['members.*']],
        ['location', 'fa-map-marker-alt', 'Lokasi', ['location']],
    ];
    $laporanAktif = request()->routeIs('report.*');
@endphp

<a href="{{ route('transactions.create') }}" class="app-brand d-none d-md-flex">
    <img src="{{ asset('favicon.svg') }}" width="32" height="32" alt="">
    <span>Pinjam di LAP</span>
</a>

<ul class="nav flex-column app-nav">
    @foreach ($menu as [$route, $icon, $label, $patterns])
        <li class="nav-item {{ request()->routeIs(...$patterns) ? 'active' : '' }}">
            <a href="{{ route($route) }}" class="nav-link" @if (request()->routeIs(...$patterns)) aria-current="page" @endif>
                <span class="sidebar-icon"><i class="fas {{ $icon }} fa-fw" aria-hidden="true"></i></span>
                <span class="sidebar-text">{{ $label }}</span>
            </a>
        </li>
    @endforeach

    <li class="nav-item">
        <span class="nav-link d-flex justify-content-between align-items-center {{ $laporanAktif ? '' : 'collapsed' }}"
            role="button" tabindex="0" data-bs-toggle="collapse" data-bs-target="#submenu-laporan"
            aria-controls="submenu-laporan" aria-expanded="{{ $laporanAktif ? 'true' : 'false' }}">
            <span>
                <span class="sidebar-icon"><i class="fas fa-chart-bar fa-fw" aria-hidden="true"></i></span>
                <span class="sidebar-text">Laporan</span>
            </span>
            <span class="link-arrow"><i class="fas fa-chevron-right" aria-hidden="true"></i></span>
        </span>
        <div class="multi-level collapse {{ $laporanAktif ? 'show' : '' }}" id="submenu-laporan">
            <ul class="flex-column nav">
                @foreach ([['report.transaction', 'Transaksi', ['report.transaction']], ['report.member', 'Member', ['report.member', 'report.member-detail']], ['report.product', 'Barang', ['report.product']]] as [$route, $label, $patterns])
                    <li class="nav-item {{ request()->routeIs(...$patterns) ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route($route) }}">
                            <span class="sidebar-text">{{ $label }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </li>

    <li role="separator" class="app-nav__sep"></li>

    <li class="nav-item {{ request()->routeIs('post.*') ? 'active' : '' }}">
        <a href="{{ route('post.index') }}" class="nav-link">
            <span class="sidebar-icon"><i class="fas fa-newspaper fa-fw" aria-hidden="true"></i></span>
            <span class="sidebar-text">Informasi</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('users.index') ? 'active' : '' }}">
        <a href="{{ route('users.index') }}" class="nav-link">
            <span class="sidebar-icon"><i class="fas fa-user-shield fa-fw" aria-hidden="true"></i></span>
            <span class="sidebar-text">Petugas</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('about') ? 'active' : '' }}">
        <a href="{{ route('about') }}" class="nav-link">
            <span class="sidebar-icon"><i class="fas fa-question-circle fa-fw" aria-hidden="true"></i></span>
            <span class="sidebar-text">Panduan</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ url('/') }}" class="nav-link" target="_blank" rel="noopener">
            <span class="sidebar-icon"><i class="fas fa-external-link-alt fa-fw" aria-hidden="true"></i></span>
            <span class="sidebar-text">Lihat situs publik</span>
        </a>
    </li>
</ul>
