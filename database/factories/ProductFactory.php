<?php

namespace Database\Factories;

use App\Models\Cabinet;
use App\Models\Location;
use App\Models\Product;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Mengikuti skema migration (kolom `code`, `locker_id`).
 * Status produk yang dipakai aplikasi:
 *  tersedia | process | menunggu persetujuan
 *
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'image' => null,
            'code' => 'BRG-' . fake()->unique()->numerify('#####'),
            'name' => fake()->randomElement([
                'Proyektor Epson EB-X51', 'Laptop Lenovo ThinkPad E14', 'Kamera Canon EOS M50',
                'Mikrofon Wireless Shure', 'Speaker Portable JBL', 'Tripod Takara',
                'Kabel HDMI 10m', 'Pointer Logitech R400', 'Layar Proyektor 70"',
            ]),
            'amount' => '1',
            'status' => 'tersedia',
            'location_id' => Location::factory(),
            'room_id' => fn (array $a) => Room::factory()->create(['location_id' => $a['location_id']])->id,
            'locker_id' => fn (array $a) => Cabinet::factory()->create(['room_id' => $a['room_id']])->id,
            'info' => fake('id_ID')->optional(0.5)->sentence(),
        ];
    }

    public function process(): static
    {
        return $this->state(['status' => 'process']);
    }

    public function menungguPersetujuan(): static
    {
        return $this->state(['status' => 'menunggu persetujuan']);
    }

    /** Edge case: lemari opsional null. */
    public function tanpaLemari(): static
    {
        return $this->state(['locker_id' => null]);
    }
}
