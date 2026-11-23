<?php

namespace Tests\Feature\Smoke;

use Illuminate\Support\Facades\Hash;

class UserProfileTest extends SmokeTestCase
{
    public function test_about_dan_daftar_user(): void
    {
        $this->actingAsAdmin()->get('/about')->assertOk();
        $this->actingAsAdmin()->get('/users')->assertOk()->assertSee('Siti Rahmawati');
    }

    public function test_profil_tampil(): void
    {
        $this->actingAsAdmin()->get('/profile')->assertOk()->assertSee('admin@peminjaman.test');
    }

    public function test_profil_update_nama_email_dan_password(): void
    {
        $this->actingAsAdmin()->from('/profile')->put('/profile', [
            'name' => 'Admin Baru', 'email' => 'admin.baru@peminjaman.test',
            'password' => 'passwordbaru', 'password_confirmation' => 'passwordbaru',
        ])->assertRedirect('/profile')->assertSessionHas('success', 'Profil berhasil diperbarui.');

        $user = \App\Models\User::where('email', 'admin.baru@peminjaman.test')->firstOrFail();
        $this->assertSame('Admin Baru', $user->name);
        $this->assertTrue(Hash::check('passwordbaru', $user->password));
    }

    public function test_profil_update_tanpa_password_tidak_mengubah_password(): void
    {
        $this->actingAsAdmin()->put('/profile', ['name' => 'Admin', 'email' => 'admin@peminjaman.test', 'password' => ''])
            ->assertSessionHasNoErrors();
        $this->assertTrue(Hash::check('password', $this->admin()->password));
    }

    public function test_profil_validasi(): void
    {
        $this->actingAsAdmin()->put('/profile', [
            'name' => '', 'email' => 'petugas@peminjaman.test',
            'password' => 'pendek', 'password_confirmation' => 'beda',
        ])->assertSessionHasErrors([
            'name' => 'The name field is required.',
            'email' => 'The email has already been taken.',
            'password',
        ]);
    }
}
