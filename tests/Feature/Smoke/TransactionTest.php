<?php

namespace Tests\Feature\Smoke;

use App\Models\Transaction;
use App\Models\TransactionItem;

class TransactionTest extends SmokeTestCase
{
    public function test_dashboard_dengan_data_seeder(): void
    {
        $this->actingAsAdmin()->get('/dashboard')->assertOk()->assertSee('Putri Ayu Wulandari');
    }

    public function test_dashboard_tanpa_member_dan_produk_process(): void
    {
        \App\Models\Member::query()->update(['status' => 'tidak_ada']);
        \App\Models\Product::query()->update(['status' => 'tersedia']);
        $this->actingAsAdmin()->get('/dashboard')->assertOk();
    }

    public function test_index_hanya_menampilkan_transaksi_disetujui(): void
    {
        $this->actingAsAdmin()->get('/transactions')->assertOk()
            ->assertSee('Dewi Lestari')->assertDontSee('Rizky Hidayat');
        $this->actingAsAdmin()->get('/transactions?search=Dewi')->assertOk()->assertSee('Dewi Lestari');
    }

    public function test_detail_transaksi(): void
    {
        $trx = $this->approvedTransaction();
        $this->actingAsAdmin()->get("/transactions/{$trx->id}")->assertOk()
            ->assertSee('Dewi Lestari')->assertSee('Speaker Portable JBL EON');
    }

    public function test_detail_transaksi_tidak_ada_404(): void
    {
        $this->actingAsAdmin()->get('/transactions/999999')->assertNotFound();
    }

    public function test_alur_peminjaman_store_approve_kembalikan(): void
    {
        $member = $this->member('3273012001990001');
        $p1 = $this->product('BRG-0001');
        $p2 = $this->product('BRG-0004');

        $this->actingAsAdmin()->post('/transactions', [
            'member_id' => $member->id, 'products' => [$p1->id, $p2->id],
        ])->assertOk();

        $trx = Transaction::where('member_id', $member->id)->where('status', 'diproses')->firstOrFail();
        $this->assertSame(2, $trx->total);
        $this->assertSame('menunggu persetujuan', $p1->fresh()->status);

        $this->actingAsAdmin()->post('/transactions/approve', ['id' => $trx->id, 'collateral' => 'KTP'])
            ->assertRedirect('transactions');
        $this->assertSame('disetujui', $trx->fresh()->status);
        $this->assertSame('meminjam', $member->fresh()->status);

        $this->actingAsAdmin()->post('/transactions/return', ['id' => $trx->id])->assertRedirect();
        $this->assertSame('selesai', $trx->fresh()->status);
        $this->assertSame('tersedia', $p1->fresh()->status);
        $this->assertSame('tidak_ada', $member->fresh()->status);
        foreach ($trx->fresh()->transactionitem as $item) {
            $this->assertSame('selesai', $item->status, 'Status item setelah pengembalian penuh');
        }
    }

    public function test_kembalikan_per_barang_menyelesaikan_transaksi_bila_semua_kembali(): void
    {
        $trx = $this->approvedTransaction();
        [$a, $b] = $trx->transactionitem->all();

        $this->actingAsAdmin()->from("/transactions/{$trx->id}")
            ->post('/transactions/return-product', ['id' => $a->id])->assertRedirect("/transactions/{$trx->id}");
        $this->assertSame('disetujui', $trx->fresh()->status);
        $this->assertSame('tersedia', $a->product->fresh()->status);

        $this->actingAsAdmin()->post('/transactions/return-product', ['id' => $b->id]);
        $this->assertSame('selesai', $trx->fresh()->status);
        $this->assertSame('tidak_ada', $trx->member->fresh()->status, 'Member masih berstatus meminjam setelah semua barang kembali');
    }

    public function test_store_validasi(): void
    {
        $this->actingAsAdmin()->post('/transactions', [])
            ->assertSessionHasErrors(['member_id' => 'The member id field is required.']);
        $this->actingAsAdmin()->post('/transactions', ['member_id' => 999999, 'products' => [999999]])
            ->assertSessionHasErrors([
                'member_id' => 'The selected member id is invalid.',
                'products.0' => 'The selected products.0 is invalid.',
            ]);
    }

    public function test_store_tanpa_produk_ditolak(): void
    {
        $member = $this->member('3273012001990001');
        $this->actingAsAdmin()->post('/transactions', ['member_id' => $member->id])
            ->assertSessionHasErrors('products');
    }

    public function test_store_menolak_produk_yang_tidak_tersedia(): void
    {
        $member = $this->member('3273012001990001');
        $dipinjam = $this->product('BRG-0006'); // sedang dipinjam
        $this->actingAsAdmin()->post('/transactions', ['member_id' => $member->id, 'products' => [$dipinjam->id]])
            ->assertSessionHasErrors('products.0');
    }

    public function test_approve_return_dengan_id_tidak_valid_tidak_500(): void
    {
        $this->actingAsAdmin()->post('/transactions/approve', ['id' => 999999])->assertStatus(404);
        $this->actingAsAdmin()->post('/transactions/return', ['id' => 999999])->assertStatus(404);
        $this->actingAsAdmin()->post('/transactions/return-product', ['id' => 999999])->assertStatus(404);
    }

    public function test_approve_tanpa_jaminan_ditolak(): void
    {
        $trx = Transaction::where('status', 'diproses')->firstOrFail();
        $this->actingAsAdmin()->post('/transactions/approve', ['id' => $trx->id])
            ->assertSessionHasErrors('collateral');
    }

    public function test_approve_transaksi_diproses(): void
    {
        $trx = Transaction::where('status', 'diproses')->firstOrFail();
        $this->actingAsAdmin()->post('/transactions/approve', ['id' => $trx->id, 'collateral' => 'KTP'])
            ->assertRedirect('transactions')->assertSessionHas('message', 'Peminjaman disetujui.');
        $this->assertSame('disetujui', $trx->fresh()->status);
        $this->assertSame('KTP', $trx->fresh()->collateral);
        $this->assertSame('meminjam', $trx->member->fresh()->status);
    }

    public function test_kembalikan_semua_barang_sekaligus(): void
    {
        $trx = $this->approvedTransaction();
        $this->actingAsAdmin()->from('/transactions')->post('/transactions/return', ['id' => $trx->id])
            ->assertRedirect('/transactions')->assertSessionHas('success', 'Peminjaman selesai. Semua barang telah dikembalikan.');

        $this->assertSame('selesai', $trx->fresh()->status);
        $this->assertSame('tidak_ada', $trx->member->fresh()->status);
        foreach ($trx->fresh()->transactionitem as $item) {
            $this->assertSame('tersedia', $item->product->status);
            $this->assertSame('selesai', $item->status, "Status item tersimpan sebagai '{$item->status}'");
        }
    }
}
