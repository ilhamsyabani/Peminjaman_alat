<?php

namespace Database\Factories;

use App\Models\Member;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Status transaksi: diproses -> disetujui -> selesai
 *
 * @extends Factory<Transaction>
 */
class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        return [
            'member_id' => Member::factory(),
            'transaction_date' => fake()->dateTimeBetween('-60 days', 'now')->format('Y-m-d'),
            'total' => 0,
            'collateral' => 'belum ada',
            'status' => 'diproses',
        ];
    }

    public function disetujui(string $jaminan = 'KTP'): static
    {
        return $this->state(['status' => 'disetujui', 'collateral' => $jaminan]);
    }

    public function selesai(): static
    {
        return $this->state(['status' => 'selesai', 'collateral' => 'KTM']);
    }
}
