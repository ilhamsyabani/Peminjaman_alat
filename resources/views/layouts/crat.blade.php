<div class="card shadow border-0 text-left p-2">
    <div class="card-body pb-5">
        <h5 class="fw-normal">Daftar Pinjaman</h5>
        <p class="text-gray mb-4">{{ Session::get('username') }}</p>
        @if ($transaksi->count())
            <div class="row">
                @foreach ($transaksi as $trans)
                    <hr class="m-1 p-0">
                    <div class="col-9 mt-2">
                        <p>{{ $trans->barang->nama }}<br />
                            <small>{{ $trans->barang->location->name }}</small>
                        </p>
                    </div>

                    <div class="col-3 mt-2">
                        <form action="{{ route('transaksi.destroy', $trans->id) }}" method="post" class="d-inline">
                            @method('delete')
                            @csrf
                            <button class="btn btn-danger btn-sm"
                                onclick=" return confirm('Anda yakin Ingin Menghapus')"><i
                                    class="fa-solid fa-xmark">batal</i></button>
                        </form>
                    </div>
                @endforeach
            </div>
        @else
            <p> tidak ada daftar pinjaman</p>
        @endif
        <hr class="">
        <a class="btn btn-secondary keychainify-checked" href="{{ route('transaksi.index') }}">Pinjam</a>
    </div>
</div>
