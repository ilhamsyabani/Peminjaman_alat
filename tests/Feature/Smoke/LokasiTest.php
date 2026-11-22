<?php

namespace Tests\Feature\Smoke;

use App\Models\Location;
use App\Models\Room;

class LokasiTest extends SmokeTestCase
{
    public function test_halaman_lokasi(): void
    {
        $this->actingAsAdmin()->get('/country-state-city')->assertOk()->assertSee('Gedung Rektorat');
    }

    public function test_ajax_ruang_dan_lemari(): void
    {
        $loc = Location::where('name', 'Gedung Rektorat')->first();
        $room = Room::where('name', 'Ruang Rapat Senat')->first();

        $this->actingAsAdmin()->postJson('/get-states-by-country', ['country_id' => $loc->id])
            ->assertOk()->assertJsonCount(2, 'states');
        $this->actingAsAdmin()->postJson('/get-cities-by-state', ['state_id' => $room->id])
            ->assertOk()->assertJsonCount(2, 'cities');

        $kosong = Location::where('name', 'Gedung Perpustakaan')->first();
        $this->actingAsAdmin()->postJson('/get-states-by-country', ['country_id' => $kosong->id])
            ->assertOk()->assertJsonCount(0, 'states');
    }

    public function test_simpan_lokasi_ruang_lemari(): void
    {
        $this->actingAsAdmin()->post('/location', ['name' => 'Gedung Pascasarjana'])->assertRedirect(route('location'));
        $loc = Location::where('name', 'Gedung Pascasarjana')->firstOrFail();

        $this->actingAsAdmin()->post('/room', ['name' => 'Ruang Sidang', 'location_id' => $loc->id])->assertRedirect(route('location'));
        $room = Room::where('name', 'Ruang Sidang')->firstOrFail();

        $this->actingAsAdmin()->post('/locker', ['name' => 'Lemari Z1', 'room_id' => $room->id])->assertRedirect(route('location'));
        $this->assertDatabaseHas('cabinets', ['name' => 'Lemari Z1', 'room_id' => $room->id]);
    }

    public function test_validasi_lokasi_ruang_lemari(): void
    {
        $this->actingAsAdmin()->post('/location', [])->assertSessionHasErrors(['name' => 'The name field is required.']);
        $this->actingAsAdmin()->post('/room', [])->assertSessionHasErrors(['name', 'location_id' => 'The location id field is required.']);
        $this->actingAsAdmin()->post('/locker', [])->assertSessionHasErrors(['name', 'room_id' => 'The room id field is required.']);
    }

    public function test_ruang_dengan_lokasi_tidak_ada_ditolak(): void
    {
        $this->actingAsAdmin()->post('/room', ['name' => 'Ruang Hantu', 'location_id' => 999999])
            ->assertSessionHasErrors('location_id');
    }
}
