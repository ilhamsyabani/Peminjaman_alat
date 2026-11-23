<header class="lp-header">
    <div class="container lp-header__inner">
        <a class="lp-brand" href="{{ url('/') }}" aria-label="Pinjam di LAP — beranda">
            <img src="{{ asset('favicon.svg') }}" alt="" width="32" height="32">
            <span>Pinjam di LAP</span>
        </a>

        <nav class="lp-nav" aria-label="Navigasi utama">
            <a href="{{ url('/') }}#layanan">Layanan</a>
            <a href="{{ url('/') }}#alur">Cara meminjam</a>
            <a href="{{ url('/') }}#informasi">Informasi</a>
        </nav>

        @auth
            <a href="{{ route('transactions.create') }}" class="lp-btn lp-btn--dark lp-btn--sm">
                Dashboard <i class="fas fa-arrow-right" aria-hidden="true"></i>
            </a>
        @else
            <a href="{{ route('login') }}" class="lp-btn lp-btn--dark lp-btn--sm">Masuk</a>
        @endauth
    </div>
</header>
