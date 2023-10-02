@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header pb-0 px-3">
                        <h6 class="mb-3">Informasi member</h6>
                    </div>
                    <div class="card-body pt-4 p-3">
                        <ul class="list-group">
                            <li class="list-group-item border-0 d-flex p-4 mb-2 mt-3 bg-gray-100 border-radius-lg">
                                <div class="d-flex flex-column px-4 col-3">
                                    <img src="{{ asset('storage/' . $transaction->member->photo) }}"
                                        alt="{{ $transaction->member->image }}">
                                </div>
                                <div class="d-flex flex-column">
                                    <h6 style="font-size: 14px;">{{ $transaction->member->name }}</h6>
                                    <span style="font-size: 12px;" class="mb-0 text-xs">No handphone: <span
                                            class="text-dark font-weight-bold ms-sm-2">{{ $transaction->member->hp }}</span></span>
                                    <span style="font-size: 12px;" class="mb-0 text-xs">Email: <span
                                            class="text-dark ms-sm-2 font-weight-bold">{{ $transaction->member->email }}</span></span>
                                    <span style="font-size: 12px;" class="text-xs">Alamat: <span
                                            class="text-dark ms-sm-2 font-weight-bold">{{ $transaction->member->address }}</span></span>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <hr>
                    <div class="pb-0 px-3">
                        <h6 class="mb-0">Daftar barang</h6>
                    </div>
                    <div class="pt-4 p-3">
                        <ul class="list-group">
                            @foreach ($transaction->transactionitem as $item)
                                <li
                                    class="list-group-item border-0 d-flex justify-content-start ps-0 mb-2 border-radius-lg">
                                    <div class="d-flex flex-column px-2">
                                        <img src="{{ asset('storage/' . $item->product->image) }}" style="height:50px"
                                            alt="">
                                    </div>
                                    <div class="d-flex flex-column px-2">
                                        <h6 class="mb-1 text-dark font-weight-bold text-sm">{{ $item->product->name }}
                                        </h6>
                                        <span class="text-xs" style="font-size:12px">{{ $item->product->location->name }},
                                            {{ $item->product->room->name }},
                                            {{ $item->product->cabinet->name }}</span>
                                    </div>

                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <hr>
                    <form action="{{ route('transactions.approve') }}" method="POST">
                        @csrf
                        <div class="pt-4 p-3">
                            <div class="mb-2">
                                <label class="my-1 me-2" for="collateral">Jaminan :</label>
                                <select class="form-select @error('collateral') is-invalid @enderror" id="collateral"
                                    name="collateral" aria-label="Default select example">
                                    <option value="KTM">KTM</option>
                                    <option value="KTP">KTP</option>
                                </select>
                                @error('collateral')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <input type="hidden" name="id" value="{{ $transaction->id }}">
                            <button class="btn btn-sm btn-gray-800  align-items-center m-2" type="submit">Setujui
                                pinjaman</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
