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
                                    <img src="{{ asset('storage/' . $member->photo) }}"
                                        alt="{{ $member->image }}">
                                </div>
                                <div class="d-flex flex-column">
                                    <h6 style="font-size: 14px;">{{ $member->name }}</h6>
                                    <span style="font-size: 12px;" class="mb-0 text-xs">No handphone: <span
                                            class="text-dark font-weight-bold ms-sm-2">{{ $member->hp }}</span></span>
                                    <span style="font-size: 12px;" class="mb-0 text-xs">Email: <span
                                            class="text-dark ms-sm-2 font-weight-bold">{{ $member->email }}</span></span>
                                    <span style="font-size: 12px;" class="text-xs">Alamat: <span
                                            class="text-dark ms-sm-2 font-weight-bold">{{ $member->address }}</span></span>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <hr>
                    <div class="pb-0 px-3">
                        <h6 class="mb-0">Daftar Peminjaman</h6>
                    </div>
                    <div class="pt-4 p-3">
                        <ul class="list-group">
                            @foreach ($member->transaction as $transaction)
                                <li
                                    class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                    <div class="d-flex">
                                        <div class="d-flex flex-column px-2">
                                            <h6 class="mb-1 text-dark font-weight-bold text-sm">tanggal peminjaman: {{ $transaction->transaction_date }}
                                            </h6>
                                            <span class="text-xs"
                                                style="font-size:12px">Jaminan: {{ $transaction->collateral}},</span>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column px-2">
                                        <div class="btn-group">
                                            <a class="keychainify-checked p-2" href="{{ route('transactions.view', $transaction) }}">detail</a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </div>
@endsection
