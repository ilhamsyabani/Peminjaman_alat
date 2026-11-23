<div class="user-card d-flex d-md-none align-items-center justify-content-between pb-4">
    <div class="d-flex align-items-center">
        @include('partials.avatar', ['name' => auth()->user()->name, 'size' => 44])
        <div class="ms-3">
            <p class="h6 text-white mb-2">{{ auth()->user()->name }}</p>
            <a class="btn btn-secondary btn-sm d-inline-flex align-items-center" href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt me-1" aria-hidden="true"></i> Keluar
            </a>
        </div>
    </div>
    <div class="collapse-close d-md-none">
        <a href="#sidebarMenu" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu"
            aria-expanded="true" aria-label="Tutup menu">
            <i class="fas fa-times" aria-hidden="true"></i>
        </a>
    </div>
</div>
