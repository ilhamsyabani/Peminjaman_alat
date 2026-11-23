@foreach (['success' => 'success', 'status' => 'success', 'message' => 'success', 'error' => 'danger'] as $key => $variant)
    @if (session($key))
        <div class="alert alert-{{ $variant }} alert-dismissible fade show d-flex align-items-center" role="{{ $variant === 'danger' ? 'alert' : 'status' }}">
            <i class="fas {{ $variant === 'danger' ? 'fa-exclamation-circle' : 'fa-check-circle' }} me-2" aria-hidden="true"></i>
            <span>{{ session($key) }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif
@endforeach
