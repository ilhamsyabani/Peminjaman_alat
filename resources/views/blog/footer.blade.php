<footer class="lp-footer">
    <div class="container lp-footer__inner">
        <div>
            <a class="lp-brand lp-brand--light" href="{{ url('/') }}">
                <img src="{{ asset('favicon.svg') }}" alt="" width="28" height="28">
                <span>Pinjam di LAP</span>
            </a>
            <p class="lp-footer__text">Laboratorium Teknologi Pendidikan<br>Fakultas Ilmu Pendidikan, Universitas Negeri Yogyakarta</p>
        </div>
        <p class="lp-footer__copy">&copy; {{ now()->year }} LAP TP FIP UNY</p>
    </div>
</footer>
