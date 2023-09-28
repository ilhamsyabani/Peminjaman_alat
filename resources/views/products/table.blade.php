@foreach ($products as $product)
<tr>
    <td><{{ $product->name }} <span>{{ $product->kode }}</span></td>
    <td>{{ $product->location->name }}, {{ $product->room->name }}, {{ $product->cabinet->name }}</td>
    <td>{{ $product->info }}</td>
    <td>{{ $product->status }}</td>
</tr>
@endforeach