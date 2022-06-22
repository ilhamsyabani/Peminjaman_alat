<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBarangRequest;
use App\Http\Requests\UpdateBarangRequest;
use App\Models\Barang;
use App\Models\Location;
use App\Models\Room;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view("barang.index", [
            'barangs' => Barang::latest()->filter(request(['search', 'room']))->paginate(5),
            'rooms' => Room::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data['countries'] = Location::get(["name", "id"]);
        return view("barang.create", $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBarangRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBarangRequest $request)
    {
        //DD($request);
        $validations = $request->validate([
            'image' => 'image|file|max:1024',
            'kode' => 'required|unique:barangs|',
            'nama' => 'required',
            'status' => 'required',
            'kondisi' => 'required',
            'keterangan' => 'max:225|nullable',
            'location_id' => 'required',
            'room_id' => 'max:225',
            'locker_id' => 'max:25|nullable',
        ]);

        if ($request->file('image')) {
            $validations['image'] = $request->file('image')->store('img-sourece');
        }

        Barang::create($validations);

        return redirect()->route('barang.index')
            ->with('success', 'Items created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */

    public function show(Barang $barang)
    {
        //
        return view("barang.view", compact('barang'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function edit(Barang $barang)
    {
        //

        return view("barang.edit", [
            'countries' => Location::get(["name", "id"]),
            'barang' => $barang,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBarangRequest  $request
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBarangRequest $request, Barang $barang)
    {
        //
        $rules = [
            'nama' => 'required',
            'status' => 'required',
            'kondisi' => 'required',
            'location_id' => 'required',
            'room_id' => 'max:225',
            'locker_id' => 'max:255|nullable',
            'keterangan' => 'max:255|nullable',
        ];

        if ($request->kode != $barang->kode) {
            $rules['kode'] = 'requeired|unique:items';
        }

        $validatedItem = $request->validate($rules);

        if ($request->file('image')) {
            if ($request->oldImg) {
                Storage::delete($request->oldImg);
            }
            $validatedItem['image'] = $request->file('image')->store('img-source');
        }

        Barang::where('id', $barang->id)->update($validatedItem);

        return  redirect()->route('barang.index')->with('success', 'Data Bearang telah diuabah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Barang $barang)
    {
        //
        if ($barang->image) {
            Storage::delete($barang->image);
        }

        Barang::destroy($barang->id);
        return  redirect()->route('barang.index')->with('success', 'Item deleted successfully');
    }
}
