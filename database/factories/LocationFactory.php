<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Location>
 */
class LocationFactory extends Factory
{
    protected $model = Location::class;

    public function definition(): array
    {
        return [
            'name' => 'Gedung ' . fake('id_ID')->randomElement(['A', 'B', 'C', 'Rektorat', 'Laboratorium', 'Perpustakaan']) . ' ' . fake()->unique()->numberBetween(1, 9999),
        ];
    }
}
