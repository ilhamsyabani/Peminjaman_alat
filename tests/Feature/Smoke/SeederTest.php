<?php

namespace Tests\Feature\Smoke;

use App\Models\Cabinet;
use App\Models\Location;
use App\Models\Member;
use App\Models\Post;
use App\Models\Product;
use App\Models\Room;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;

class SeederTest extends SmokeTestCase
{
    private function counts(): array
    {
        return collect([User::class, Location::class, Room::class, Cabinet::class, Product::class,
            Member::class, Transaction::class, TransactionItem::class, Post::class])
            ->mapWithKeys(fn ($m) => [$m => $m::count()])->all();
    }

    public function test_seeder_mengisi_semua_tabel_dan_status_penting(): void
    {
        $this->assertSame(3, User::count());
        $this->assertSame(8, Product::count());
        $this->assertSame(6, Member::count());
        $this->assertEqualsCanonicalizing(['diproses', 'disetujui', 'selesai'], Transaction::distinct()->pluck('status')->all());
        $this->assertEqualsCanonicalizing(['tidak_ada', 'process', 'meminjam'], Member::distinct()->pluck('status')->all());
        $this->assertEqualsCanonicalizing(['tersedia', 'process', 'menunggu persetujuan'], Product::distinct()->pluck('status')->all());
        $this->assertSame(1, Product::whereNull('locker_id')->count(), 'edge case: produk tanpa lemari');
        $this->assertSame(1, Transaction::where('total', 0)->count(), 'edge case: transaksi kosong');
    }

    public function test_seeder_idempotent_saat_dijalankan_ulang(): void
    {
        $before = $this->counts();
        $this->seed(DatabaseSeeder::class);
        $this->seed(DatabaseSeeder::class);
        $this->assertSame($before, $this->counts());
    }

    public function test_semua_factory_dapat_membuat_data_dengan_relasi(): void
    {
        $item = TransactionItem::factory()->create();
        $this->assertNotNull($item->transaction->member);
        $this->assertNotNull($item->product->location);
        $this->assertNotNull($item->product->room);
        $this->assertNotNull(Post::factory()->create()->user);
        $this->assertNotNull(Cabinet::factory()->create()->room);
    }
}
