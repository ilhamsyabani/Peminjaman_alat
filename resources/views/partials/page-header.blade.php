{{--
    Header halaman admin.
    $title, $subtitle (opsional), $crumbs: [['Label', url|null], ...], $action: ['url', 'Label', 'fa-icon'] (opsional)
--}}
<div class="app-page-header">
    <div>
        @if (!empty($crumbs))
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-transparent mb-1">
                    <li class="breadcrumb-item">
                        <a href="{{ route('transactions.create') }}" aria-label="Dashboard"><i class="fas fa-home" aria-hidden="true"></i></a>
                    </li>
                    @foreach ($crumbs as [$label, $url])
                        @if ($url && !$loop->last)
                            <li class="breadcrumb-item"><a href="{{ $url }}">{{ $label }}</a></li>
                        @else
                            <li class="breadcrumb-item active" aria-current="page">{{ $label }}</li>
                        @endif
                    @endforeach
                </ol>
            </nav>
        @endif
        <h1 class="app-page-header__title">{{ $title }}</h1>
        @if (!empty($subtitle))
            <p class="app-page-header__subtitle">{{ $subtitle }}</p>
        @endif
    </div>
    @if (!empty($action))
        <a href="{{ $action[0] }}" class="btn btn-gray-800 d-inline-flex align-items-center">
            <i class="fas {{ $action[2] ?? 'fa-plus' }} me-2" aria-hidden="true"></i>{{ $action[1] }}
        </a>
    @endif
</div>
