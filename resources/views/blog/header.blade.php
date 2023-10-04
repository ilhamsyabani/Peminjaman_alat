<header class="" style=" background-color:#F5F5F5">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light d-flex justify-content-between">
            <a class="navbar-brand" href="index.html"><img src="{{ asset('assets/images/logo.svg') }}" alt="Edica"></a>
            <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#edicaMainNav" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <ul class="navbar-nav mt-2 mt-lg-0">
                @if (Route::has('login'))
                  <li class="nav-item">
                    @auth
                        <a href="{{ route('transactions.create') }}" class="text-sm text-gray-700  dark:text-gray-500 underline" style="color:#4A4C58">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline" style="color:#4A4C58">Log in</a>
                    @endauth
                  </li>
                @endif
            </ul>
        </nav>
    </div>
</header>