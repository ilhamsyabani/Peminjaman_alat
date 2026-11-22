@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1>{{ $product->name }}</h1>
    <dl class="row">
        <dt class="col-sm-3">Kode</dt><dd class="col-sm-9">{{ $product->code }}</dd>
        <dt class="col-sm-3">Status</dt><dd class="col-sm-9">{{ $product->status }}</dd>
        <dt class="col-sm-3">Lokasi</dt><dd class="col-sm-9">{{ $product->location?->name ?? '—' }}</dd>
        <dt class="col-sm-3">Ruang</dt><dd class="col-sm-9">{{ $product->room?->name ?? '—' }}</dd>
        <dt class="col-sm-3">Lemari</dt><dd class="col-sm-9">{{ $product->cabinet?->name ?? '—' }}</dd>
        <dt class="col-sm-3">Keterangan</dt><dd class="col-sm-9">{{ $product->info ?? '—' }}</dd>
    </dl>
    <a href="{{ route('products.index') }}">Kembali</a>
</div>
@endsection
