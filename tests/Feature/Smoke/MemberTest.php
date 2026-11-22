<?php

namespace Tests\Feature\Smoke;

use App\Models\Member;
use Illuminate\Support\Facades\Storage;

class MemberTest extends SmokeTestCase
{
    private const PNG_BASE64 = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==';

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake();
    }

    private function validPayload(array $override = []): array
    {
        return array_merge([
            'photo' => self::PNG_BASE64,
            'name' => 'Agus Salim', 'identity_number' => '3273010101900099',
            'email' => 'agus@mail.test', 'hp' => '081299990000',
            'address' => 'Jl. Braga No. 1, Bandung', 'info' => null, 'status' => 'tidak_ada',
        ], $override);
    }

    public function test_index_create_show_edit(): void
    {
        $m = $this->member('3273012001990001');
        $this->actingAsAdmin()->get('/members')->assertOk()->assertSee('Andi Pratama');
        $this->actingAsAdmin()->get('/members?search=Dewi')->assertOk()->assertSee('Dewi Lestari')->assertDontSee('Andi Pratama');
        $this->actingAsAdmin()->get('/members/create')->assertOk();
        $this->actingAsAdmin()->get("/members/{$m->id}")->assertOk()->assertSee('Andi Pratama');
        $this->actingAsAdmin()->get("/members/{$m->id}/edit")->assertOk()->assertSee('Andi Pratama');
    }

    public function test_show_member_tidak_ada_404(): void
    {
        $this->actingAsAdmin()->get('/members/999999')->assertNotFound();
    }

    public function test_store_member_dengan_foto_webcam(): void
    {
        $this->actingAsAdmin()->post('/members', $this->validPayload())
            ->assertRedirect(route('members.index'));

        $member = Member::where('identity_number', '3273010101900099')->firstOrFail();
        Storage::assertExists($member->photo);
    }

    public function test_store_member_input_kosong_ditolak_dengan_pesan_validasi(): void
    {
        $this->actingAsAdmin()->post('/members', [])
            ->assertSessionHasErrors([
                'name' => 'The name field is required.',
                'identity_number' => 'The identity number field is required.',
                'email' => 'The email field is required.',
                'status' => 'The status field is required.',
            ]);
    }

    public function test_store_member_validasi_tidak_menyimpan_file_yatim(): void
    {
        $this->actingAsAdmin()->post('/members', $this->validPayload(['name' => '']))
            ->assertSessionHasErrors('name');
        $this->assertEmpty(Storage::allFiles('uploads'), 'Foto tersimpan walaupun validasi gagal');
    }

    public function test_store_member_email_tidak_valid_dan_nik_duplikat_ditolak(): void
    {
        $this->actingAsAdmin()->post('/members', $this->validPayload([
            'email' => 'bukan-email', 'identity_number' => '3273012001990001',
        ]))->assertSessionHasErrors(['email', 'identity_number']);
    }

    public function test_update_member(): void
    {
        $m = $this->member('3273012001990001');
        $this->actingAsAdmin()->put("/members/{$m->id}", [
            'name' => 'Andi Pratama Putra', 'identity_number' => $m->identity_number,
            'email' => $m->email, 'hp' => '0811', 'address' => 'Jl. Baru', 'info' => null,
        ])->assertRedirect('/members');
        $this->assertSame('Andi Pratama Putra', $m->fresh()->name);
    }

    public function test_update_member_validasi(): void
    {
        $m = $this->member('3273012001990001');
        $this->actingAsAdmin()->put("/members/{$m->id}", ['name' => ''])
            ->assertSessionHasErrors(['name' => 'The name field is required.', 'hp', 'address']);
    }

    public function test_hapus_member(): void
    {
        $m = $this->member('3201010101010006');
        $this->actingAsAdmin()->delete("/members/{$m->id}")->assertRedirect(route('members.index'));
        $this->assertModelMissing($m);
    }

    public function test_member_yang_masih_meminjam_tidak_boleh_dihapus(): void
    {
        $m = $this->member('3273014502000002'); // status meminjam, punya transaksi disetujui
        $this->actingAsAdmin()->delete("/members/{$m->id}");
        $this->assertModelExists($m);
    }
}
