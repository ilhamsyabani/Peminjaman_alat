<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Status member yang dipakai aplikasi:
 *  - tidak_ada : tidak sedang meminjam (default)
 *  - process   : sedang dipilih di dashboard untuk transaksi baru
 *  - meminjam  : punya transaksi yang sudah disetujui
 *
 * @extends Factory<Member>
 */
class MemberFactory extends Factory
{
    protected $model = Member::class;

    public function definition(): array
    {
        $faker = fake('id_ID');

        return [
            'photo' => 'uploads/' . $faker->uuid() . '.png',
            'name' => $faker->name(),
            'identity_number' => $faker->unique()->nik(),
            'email' => $faker->unique()->safeEmail(),
            'hp' => $faker->phoneNumber(),
            'address' => $faker->address(),
            'info' => $faker->optional(0.5)->sentence(),
            'status' => 'tidak_ada',
        ];
    }

    public function process(): static
    {
        return $this->state(['status' => 'process']);
    }

    public function meminjam(): static
    {
        return $this->state(['status' => 'meminjam']);
    }

    /** Edge case: kolom opsional null. */
    public function tanpaInfo(): static
    {
        return $this->state(['info' => null]);
    }
}
