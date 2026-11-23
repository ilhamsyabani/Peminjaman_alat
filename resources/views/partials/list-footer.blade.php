{{-- $paginator --}}
@if ($paginator->total() > 0)
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mt-3 px-1">
        <p class="small text-gray-500 mb-0">
            Menampilkan {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} dari {{ $paginator->total() }} data
        </p>
        {{ $paginator->onEachSide(1)->links() }}
    </div>
@endif
