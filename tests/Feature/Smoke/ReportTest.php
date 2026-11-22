<?php

namespace Tests\Feature\Smoke;

class ReportTest extends SmokeTestCase
{
    public function test_laporan_transaksi(): void
    {
        $this->actingAsAdmin()->get('/report/transaction')->assertOk()->assertSee('Dewi Lestari');
    }

    public function test_laporan_transaksi_pencarian_nama_member(): void
    {
        $this->actingAsAdmin()->get('/report/transaction?search=Dewi')->assertOk()
            ->assertSee('Dewi Lestari')->assertDontSee('Fajar Nugroho');
    }

    public function test_laporan_member_dan_pencarian(): void
    {
        $this->actingAsAdmin()->get('/report/member')->assertOk()->assertSee('Andi Pratama');
        $this->actingAsAdmin()->get('/report/member?search=Fajar')->assertOk()->assertSee('Fajar Nugroho');
    }

    public function test_laporan_detail_member(): void
    {
        $m = $this->member('3273012001990001');
        $this->actingAsAdmin()->get("/report/member/{$m->id}")->assertOk()->assertSee('Andi Pratama');
    }

    public function test_laporan_detail_member_tanpa_transaksi(): void
    {
        $m = $this->member('3201010101010006');
        $this->actingAsAdmin()->get("/report/member/{$m->id}")->assertOk();
    }

    public function test_laporan_produk_dan_pencarian(): void
    {
        $this->actingAsAdmin()->get('/report/product')->assertOk()->assertSee('Proyektor Epson');
        $this->actingAsAdmin()->get('/report/product?search=Kamera')->assertOk()->assertSee('Kamera Canon');
    }

    public function test_laporan_produk_menampilkan_kode(): void
    {
        $this->actingAsAdmin()->get('/report/product')->assertOk()->assertSee('BRG-0001');
    }

    public function test_paginasi_tidak_valid_tidak_500(): void
    {
        $this->actingAsAdmin()->get('/report/member?pagination=abc')->assertOk();
    }
}
