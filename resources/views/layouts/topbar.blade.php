<nav class="navbar navbar-top navbar-expand navbar-dashboard ps-0 pe-2 pb-0 d-none d-md-flex">
    <div class="container-fluid px-0">
        <div class="d-flex justify-content-end w-100">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item dropdown ms-lg-3">
                    <a class="nav-link dropdown-toggle pt-1 px-0" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false" aria-label="Menu akun {{ auth()->user()->name }}">
                        <div class="d-flex align-items-center">
                            @include('partials.avatar', ['name' => auth()->user()->name, 'size' => 36])
                            <span class="ms-2 fw-bold text-gray-900 small d-none d-lg-inline">{{ auth()->user()->name }}</span>
                            <i class="fas fa-chevron-down ms-2 text-gray-500 small d-none d-lg-inline" aria-hidden="true"></i>
                        </div>
                    </a>
                    <div class="dropdown-menu dashboard-dropdown dropdown-menu-end mt-2 py-1">
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.show') }}">
                            <i class="fas fa-user-circle fa-fw text-gray-400 me-2" aria-hidden="true"></i> Profil saya
                        </a>
                        <div role="separator" class="dropdown-divider my-1"></div>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt fa-fw text-danger me-2" aria-hidden="true"></i> Keluar
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
