@forelse ($products as $product)
    <li class="app-result">
        @if ($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="" class="app-thumb">
        @else
            <span class="app-thumb"><i class="fas fa-box" aria-hidden="true"></i></span>
        @endif
        <div class="flex-grow-1 min-w-0">
            <div class="fw-bold text-gray-900">{{ $product->name }}</div>
            <div class="small text-gray-500 text-truncate">
                {{ $product->code }} · {{ $product->location?->name }}, {{ $product->room?->name }}{{ $product->cabinet ? ', ' . $product->cabinet->name : '' }}
            </div>
        </div>
        <form action="{{ url('/processproduct') }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $product->id }}">
            <button type="submit" class="btn btn-sm btn-gray-800" aria-label="Tambahkan barang {{ $product->name }}">Tambahkan barang</button>
        </form>
    </li>
@empty
    <li class="app-hint">Tidak ada barang tersedia yang cocok.</li>
@endforelse
