<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransaksiRequest;
use App\Http\Requests\UpdateTransaksiRequest;
use App\Models\Transaksi;
use App\Models\Barang;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transaksi::latest()->filter(request(['search', 'status']))->paginate(10);
        return view("transaksi.index", [
            'transctions' => $transactions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view("transaksi.create", [
            'barangs' => Barang::latest()->filter(request(['search']))->paginate(12),
            'transaksi' => Transaksi::where('member_id', session('user_id'))->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTransaksiRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransaksiRequest $request)
    {
        //
        $validateTran = $request->validate([
            'barang_id' => 'required',
            'member_id' => 'required',
        ]);

        Transaksi::create($validateTran);
        Barang::where('id', $request->barang_id)->update(['status' => "kosong"]);

        return redirect()->route('transaksi.create')->with('success', 'item add...!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function show(Transaksi $transaksi)
    {
        //
        return view("transaksi.view");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaksi $transaksi)
    {
        //
        return view("transaksi.edit");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTransaksiRequest  $request
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransaksiRequest $request, Transaksi $transaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaksi $transaksi)
    {
        Transaksi::destroy($transaksi->id);
        Barang::where('id', $transaksi->barang_id)->update(['status' => "tersedia"]);

        return back()->with('Barang di hapus dari daftar Pinjaman!');
    }

    public function kembali(Request $request)
    {
        //dd($request);
        Barang::where('id', $request->barang_id)->update(['status' => "tersedia"]);
        Transaksi::where('id', $request->id)->update(['status' => "selesai"]);

        return back()->with('Barang Telah Dikembalikan!');
    }

    public function send(Request $request)
    {
        //return $request->all();
        //DD($request);

        Session::put('username', $request->username);
        Session::put('user_id', $request->id);
        return redirect()->route('transaksi.create');
    }
}
