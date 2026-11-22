<?php

namespace Tests\Feature\Smoke;

use App\Models\Member;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Basis smoke test: SQLite in-memory (phpunit.xml) + DatabaseSeeder.
 * Aplikasi tidak memiliki role; "berhak" = user login, "tidak berhak" = tamu.
 */
abstract class SmokeTestCase extends TestCase
{
    use RefreshDatabase;

    /**
     * Laravel 13 me-migrate DB in-memory sekali per proses; properti $seed hanya
     * berlaku bila kelas ini yang pertama memicu migrasi. Maka seed eksplisit di
     * sini (dalam transaksi per-test yang di-rollback).
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    protected function admin(): User
    {
        return User::where('email', 'admin@peminjaman.test')->firstOrFail();
    }

    protected function actingAsAdmin(): static
    {
        return $this->actingAs($this->admin());
    }

    protected function member(string $nik): Member
    {
        return Member::where('identity_number', $nik)->firstOrFail();
    }

    protected function product(string $code): Product
    {
        return Product::where('code', $code)->firstOrFail();
    }

    protected function approvedTransaction(): Transaction
    {
        return Transaction::where('status', 'disetujui')->firstOrFail();
    }
}
