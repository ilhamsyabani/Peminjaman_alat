<?php

namespace Tests\Feature\Smoke;

use App\Models\Location;
use App\Models\Product;
use App\Models\Room;
use App\Models\Cabinet;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductTest extends SmokeTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake();
    }

    private function payload(array $override = []): array
    {
        $room = Room::where('name', 'Laboratorium Multimedia')->first();
        return array_merge([
            'kode' => 'BRG-0100', 'name' => 'Drone DJI Mini 3', 'status' => 'tersedia', 'info' => 'Baru',
            'location_id' => $room->location_id, 'room_id' => $room->id,
            'cabinet_id' => Cabinet::where('room_id', $room->id)->first()->id,
        ], $override);
    }

    public function test_index_dengan_data_seeder(): void
    {
        $this->actingAsAdmin()->get('/products')->assertOk()->assertSee('Proyektor Epson EB-X51');
    }

    public function test_index_menampilkan_kode_barang(): void
    {
        $this->actingAsAdmin()->get('/products')->assertOk()->assertSee('BRG-0001');
    }

    public function test_index_pencarian_dan_filter(): void
    {
        $this->actingAsAdmin()->get('/products?search=Kamera')->assertOk()->assertSee('Kamera Canon');
        $this->actingAsAdmin()->get('/products?filter=category1')->assertOk();
    }

    public function test_index_kosong(): void
    {
        Product::query()->delete();
        $this->actingAsAdmin()->get('/products')->assertOk();
    }

    public function test_create_dan_edit_form(): void
    {
        $p = $this->product('BRG-0001');
        $this->actingAsAdmin()->get('/products/create')->assertOk()->assertSee('Gedung Rektorat');
        $this->actingAsAdmin()->get("/products/{$p->id}/edit")->assertOk()->assertSee('Proyektor Epson');
    }

    public function test_show_produk(): void
    {
        $p = $this->product('BRG-0001');
        $this->actingAsAdmin()->get("/products/{$p->id}")->assertOk()->assertSee('Proyektor Epson');
    }

    public function test_store_produk(): void
    {
        $this->actingAsAdmin()->post('/products', $this->payload([
            'image' => UploadedFile::fake()->image('drone.jpg'),
        ]))->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', ['code' => 'BRG-0100', 'name' => 'Drone DJI Mini 3']);
        $this->assertStringStartsWith('img-source/', Product::where('code', 'BRG-0100')->value('image'));
    }

    public function test_store_produk_validasi(): void
    {
        $this->actingAsAdmin()->post('/products', [])
            ->assertSessionHasErrors([
                'kode' => 'The kode field is required.',
                'name' => 'The name field is required.',
                'location_id' => 'The location id field is required.',
                'room_id' => 'The room id field is required.',
            ]);
        $this->actingAsAdmin()->post('/products', $this->payload(['info' => str_repeat('x', 226)]))
            ->assertSessionHasErrors(['info' => 'The info must not be greater than 225 characters.']);
    }

    public function test_store_produk_kode_duplikat_ditolak(): void
    {
        $this->actingAsAdmin()->post('/products', $this->payload(['kode' => 'BRG-0001']))
            ->assertSessionHasErrors(['kode' => 'The kode has already been taken.']);
    }

    public function test_update_produk_tanpa_mengubah_kode(): void
    {
        $p = $this->product('BRG-0002');
        $this->actingAsAdmin()->put("/products/{$p->id}", $this->payload(['kode' => 'BRG-0002', 'name' => 'Laptop Lenovo (servis)']))
            ->assertRedirect(route('products.index'));
        $this->assertSame('Laptop Lenovo (servis)', $p->fresh()->name);
    }

    public function test_update_produk_dengan_kode_baru(): void
    {
        $p = $this->product('BRG-0002');
        $this->actingAsAdmin()->put("/products/{$p->id}", $this->payload(['kode' => 'BRG-0200']))
            ->assertRedirect(route('products.index'));
        $this->assertSame('BRG-0200', $p->fresh()->code);
    }

    public function test_hapus_produk(): void
    {
        $p = $this->product('BRG-0004');
        $this->actingAsAdmin()->delete("/products/{$p->id}")->assertRedirect(route('products.index'));
        $this->assertModelMissing($p);
    }

    public function test_produk_yang_sedang_dipinjam_tidak_boleh_dihapus(): void
    {
        $p = $this->product('BRG-0006');
        $this->actingAsAdmin()->delete("/products/{$p->id}");
        $this->assertModelExists($p);
    }

    public function test_pencarian_produk_dengan_kode(): void
    {
        $this->actingAsAdmin()->get('/products?search=BRG-0001')
            ->assertOk()->assertSee('BRG-0001');
    }
}
