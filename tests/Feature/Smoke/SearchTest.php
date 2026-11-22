<?php

namespace Tests\Feature\Smoke;

class SearchTest extends SmokeTestCase
{
    public function test_search_no_result(): void
    {
        $this->actingAsAdmin()->get('/search-no-result')->assertOk()->assertSee('belum ada member');
    }

    public function test_search_member(): void
    {
        $this->actingAsAdmin()->getJson('/search-member')->assertOk()->assertExactJson(['members' => []]);
        $this->actingAsAdmin()->get('/search-member?search=Andi')->assertOk()->assertSee('Andi Pratama');
        $this->actingAsAdmin()->getJson('/search-member?search=zzzzz')->assertOk()->assertJsonCount(1, 'members');
    }

    public function test_search_product_hanya_yang_tersedia(): void
    {
        $this->actingAsAdmin()->get('/search-product?search=Proyektor')->assertOk()->assertSee('Proyektor Epson');
        $this->actingAsAdmin()->get('/search-product?search=Speaker')->assertOk()->assertDontSee('Speaker Portable');
    }

    public function test_process_member_dan_produk(): void
    {
        $m = $this->member('3273012001990001');
        $p = $this->product('BRG-0001');

        $this->actingAsAdmin()->post('/processmember', ['id' => $m->id, 'status' => 'process'])->assertRedirect('dashboard');
        $this->assertSame('process', $m->fresh()->status);

        $this->actingAsAdmin()->post('/processproduct', ['id' => $p->id])->assertRedirect('dashboard');
        $this->assertSame('process', $p->fresh()->status);
    }

    public function test_process_dengan_id_tidak_valid_tidak_500(): void
    {
        $this->actingAsAdmin()->post('/processmember', ['id' => 999999, 'status' => 'process'])->assertNotFound();
        $this->actingAsAdmin()->post('/processproduct', ['id' => 999999])->assertNotFound();
    }

    public function test_process_member_menolak_status_sembarang(): void
    {
        $m = $this->member('3273012001990001');
        $this->actingAsAdmin()->post('/processmember', ['id' => $m->id, 'status' => 'hacked'])
            ->assertSessionHasErrors('status');
    }
}
