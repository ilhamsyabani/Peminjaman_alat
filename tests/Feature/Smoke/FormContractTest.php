<?php

namespace Tests\Feature\Smoke;

use App\Models\Member;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

/**
 * Mengirim field PERSIS seperti yang dikirim form Blade (temuan dari UI smoke test),
 * untuk memastikan view dan controller sepakat.
 */
class FormContractTest extends SmokeTestCase
{
    public function test_form_tambah_member_apa_adanya_diterima(): void
    {
        Storage::fake();
        // members/create.blade.php:118 mengirim status "belum meminjam"
        $this->actingAsAdmin()->post('/members', [
            'photo' => 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL/wAALCAABAAEBAREA/8QAFAABAAAAAAAAAAAAAAAAAAAACf/EABQQAQAAAAAAAAAAAAAAAAAAAAD/2gAIAQEAAD8AKp//2Q==',
            'name' => 'Wahyu Kurniawan', 'email' => 'wahyu.k@mail.test', 'identity_number' => '3273011111900077',
            'hp' => '081377788899', 'address' => 'Jl. Cihampelas No. 21', 'info' => 'Mahasiswa baru',
            'status' => 'belum meminjam',
        ])->assertSessionHasNoErrors()->assertRedirect(route('members.index'));

        $this->assertSame('tidak_ada', Member::where('identity_number', '3273011111900077')->value('status'));
    }

    public function test_form_tambah_member_menampilkan_error_dan_mempertahankan_input(): void
    {
        $this->actingAsAdmin()->from('/members/create')->post('/members', ['name' => 'Wahyu', 'status' => 'xxx']);
        $this->actingAsAdmin()->get('/members/create')
            ->assertSee('value="Wahyu"', false)                 // old('name')
            ->assertSee('The selected status is invalid.');      // error status tampil
    }

    public function test_form_edit_member_menyimpan_keterangan(): void
    {
        $m = $this->member('3471010909970005');
        // members/edit.blade.php:116 memakai name="keterangan", :120 status "belum meminjam"
        $this->actingAsAdmin()->put("/members/{$m->id}", [
            'name' => $m->name, 'identity_number' => $m->identity_number, 'email' => $m->email,
            'hp' => $m->hp, 'address' => $m->address,
            'keterangan' => 'Keterangan diubah lewat UI', 'status' => 'belum meminjam',
        ])->assertSessionHasNoErrors();

        $this->assertSame('Keterangan diubah lewat UI', $m->fresh()->info);
    }

    public function test_konten_trix_tampil_sebagai_teks_bukan_tag_mentah(): void
    {
        $post = Post::first();
        $post->update(['content' => '<div onclick="alert(1)">Barang <strong>wajib</strong> dikembalikan. <a href="javascript:alert(1)">Baca</a></div><script>alert(1)</script>']);

        $this->get(route('blog.post', $post))
            ->assertOk()
            ->assertDontSee('&lt;div&gt;', false)     // tag format tidak tampil mentah
            ->assertSee('<strong>wajib</strong>', false)
            ->assertDontSee('<script>alert(1)</script>', false)
            ->assertDontSee('onclick=', false)
            ->assertDontSee('javascript:', false); // tetap aman dari XSS
    }

    public function test_detail_transaksi_menampilkan_tombol_kembalikan_untuk_barang_belum_kembali(): void
    {
        $trx = $this->approvedTransaction(); // 2 item berstatus "diproses"
        $html = $this->actingAsAdmin()->get("/transactions/{$trx->id}")->assertOk()->getContent();

        $this->assertSame(2, substr_count($html, route('transactions.return.product')), 'Form kembalikan per barang tidak dirender');
        $this->assertStringNotContainsString('barang sudah dikembalikan', $html, 'Barang yang belum kembali ditandai sudah dikembalikan');
        $this->assertSame('diproses', $trx->transactionitem()->first()->status, 'Render view mengubah status item');
    }

    public function test_tombol_selesaikan_pinjaman_berada_dalam_form_return(): void
    {
        $trx = $this->approvedTransaction();
        $html = $this->actingAsAdmin()->get("/transactions/{$trx->id}")->getContent();

        $this->assertMatchesRegularExpression(
            '#<form[^>]+action="' . preg_quote(route('transactions.return'), '#') . '"[^>]*>(?:(?!</form>).)*Selesaikan#s',
            $html, 'Tombol "Selesaikan pinjaman" tidak berada di dalam <form action=transactions.return>'
        );
    }
}
