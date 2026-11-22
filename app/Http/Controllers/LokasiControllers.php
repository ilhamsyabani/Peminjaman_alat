<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Location, Room, Cabinet};

class LokasiControllers extends Controller
{
    public function index()
    {
        $data['rooms'] = Room::get(["name", "id"]);
        $data['countries'] = Location::get(["name", "id"]);
        return view('lokasi.index', $data);
    }
    public function getState(Request $request)
    {
        $data['states'] = Room::where("location_id", $request->country_id)
            ->get(["name", "id"]);
        return response()->json($data);
    }
    public function getCity(Request $request)
    {
        $data['cities'] = Cabinet::where("room_id", $request->state_id)
            ->get(["name", "id"]);
        return response()->json($data);
    }

    public function storeloc(Request $request)
    {
        $validations = $request->validate([
            'name' => 'required',
        ]);

        Location::create($validations);

        return redirect()->route('location')
            ->with('success', 'Items created successfully.');
    }


    public function storeroom(Request $request)
    {
        $validations = $request->validate([
            'name' => 'required',
            'location_id' => 'required|integer|exists:locations,id'
        ]);

        Room::create($validations);

        return redirect()->route('location')
            ->with('success', 'Room created successfully.');
    }

    public function storelocker(Request $request)
    {
        $validations = $request->validate([
            'name' => 'required',
            'room_id' => 'required|integer|exists:rooms,id'
        ]);

        Cabinet::create($validations);

        return redirect()->route('location')
            ->with('success', 'Lemari created successfully.');
    }
}
