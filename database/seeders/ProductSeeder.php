<?php

namespace Database\Seeders;

use App\Models\Cabinet;
use App\Models\Location;
use App\Models\Product;
use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Bergantung pada LokasiSeeder.
 */
class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // code, name, status, lokasi, ruang, lemari (null = tanpa lemari), info
            ['BRG-0001', 'Proyektor Epson EB-X51', 'tersedia', 'Gedung Rektorat', 'Ruang Rapat Senat', 'Lemari A1', 'Lengkap dengan kabel HDMI dan remote'],
            ['BRG-0002', 'Laptop Lenovo ThinkPad E14', 'tersedia', 'Gedung Rektorat', 'Ruang Tata Usaha', 'Lemari B1', null],
            ['BRG-0003', 'Kamera Canon EOS M50', 'tersedia', 'Gedung Fakultas Teknik', 'Laboratorium Multimedia', 'Lemari C1', 'Baterai cadangan 2 buah'],
            ['BRG-0004', 'Tripod Takara ECO-196A', 'tersedia', 'Gedung Fakultas Teknik', 'Laboratorium Multimedia', 'Lemari C2', null],
            ['BRG-0005', 'Mikrofon Wireless Shure BLX24', 'process', 'Gedung Rektorat', 'Ruang Rapat Senat', 'Lemari A2', null],
            ['BRG-0006', 'Speaker Portable JBL EON', 'menunggu persetujuan', 'Gedung Rektorat', 'Ruang Rapat Senat', 'Lemari A2', null],
            ['BRG-0007', 'Layar Proyektor 70 inci', 'menunggu persetujuan', 'Gedung Fakultas Teknik', 'Ruang Kelas 204', null, 'Disimpan di pojok ruangan'], // edge: tanpa lemari
            ['BRG-0008', 'Kabel Roll 20 meter', 'tersedia', 'Gedung Fakultas Teknik', 'Laboratorium Multimedia', 'Lemari C1', Str::repeat('x', 225)], // edge: info tepat batas max:225
        ];

        foreach ($products as [$code, $name, $status, $loc, $roomName, $cab, $info]) {
            $location = Location::where('name', $loc)->firstOrFail();
            $room = Room::where('name', $roomName)->where('location_id', $location->id)->firstOrFail();
            $cabinet = $cab ? Cabinet::where('name', $cab)->where('room_id', $room->id)->firstOrFail() : null;

            Product::updateOrCreate(['code' => $code], [
                'name' => $name,
                'status' => $status,
                'amount' => '1',
                'location_id' => $location->id,
                'room_id' => $room->id,
                'locker_id' => $cabinet?->id,
                'info' => $info,
            ]);
        }
    }
}
