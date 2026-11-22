<?php

namespace Database\Seeders;

use App\Models\Cabinet;
use App\Models\Location;
use App\Models\Room;
use Illuminate\Database\Seeder;

class LokasiSeeder extends Seeder
{
    public function run(): void
    {
        $tree = [
            'Gedung Rektorat' => [
                'Ruang Rapat Senat' => ['Lemari A1', 'Lemari A2'],
                'Ruang Tata Usaha' => ['Lemari B1'],
            ],
            'Gedung Fakultas Teknik' => [
                'Laboratorium Multimedia' => ['Lemari C1', 'Lemari C2'],
                'Ruang Kelas 204' => [], // edge: ruang tanpa lemari
            ],
            'Gedung Perpustakaan' => [], // edge: lokasi tanpa ruang
        ];

        foreach ($tree as $locationName => $rooms) {
            $location = Location::firstOrCreate(['name' => $locationName]);

            foreach ($rooms as $roomName => $cabinets) {
                $room = Room::firstOrCreate(['name' => $roomName, 'location_id' => $location->id]);

                foreach ($cabinets as $cabinetName) {
                    Cabinet::firstOrCreate(['name' => $cabinetName, 'room_id' => $room->id]);
                }
            }
        }
    }
}
