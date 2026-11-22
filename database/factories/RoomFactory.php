<?php

namespace Database\Factories;

use App\Models\Location;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Room>
 */
class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition(): array
    {
        return [
            'name' => 'Ruang ' . fake()->numberBetween(101, 499),
            'location_id' => Location::factory(),
        ];
    }
}
