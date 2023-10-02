@foreach ($products as $product)
    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
        <div class="d-flex flex-column">
            <h6 class="mb-1 text-dark font-weight-bold text-sm">{{ $product->name }}</h6>
            <span class="text-xs">{{ $product->location->name }}, {{ $product->room->name }}, {{ $product->cabinet->name }}</span>
        </div>
        <div class="d-flex align-items-center text-sm">
            <form action="{{ url('/processproduct') }}" method="POST">
                @csrf
                <input type="hidden" name="id" id="" value="{{ $product->id }}">
            <button type="submit"  class="btn btn-sm btn-gray-800 align-items-center text-sm mb-0 px-4 ms-4">
            Tambahkan barang</button>
            </form>
        </div>
    </li>
@endforeach
