<?php

namespace Database\Factories;

use App\Models\Cabinet;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Cabinet>
 */
class CabinetFactory extends Factory
{
    protected $model = Cabinet::class;

    public function definition(): array
    {
        return [
            'name' => 'Lemari ' . fake()->randomLetter() . fake()->numberBetween(1, 20),
            'room_id' => Room::factory(),
        ];
    }
}
