<?php

namespace Tests\Feature\Smoke;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

/**
 * Route yang sebelumnya "tidak teruji": password/reset/{token}, POST password/reset,
 * dan password/confirm (GET/POST).
 */
class PasswordFlowTest extends SmokeTestCase
{
    public function test_form_reset_dengan_token_tampil(): void
    {
        $token = Password::createToken($this->admin());
        $this->get("/password/reset/{$token}?email=admin@peminjaman.test")
            ->assertOk()->assertSee('admin@peminjaman.test');
    }

    public function test_reset_password_dengan_token_valid(): void
    {
        $token = Password::createToken($this->admin());

        $this->post('/password/reset', [
            'token' => $token, 'email' => 'admin@peminjaman.test',
            'password' => 'passwordbaru1', 'password_confirmation' => 'passwordbaru1',
        ])->assertRedirect();

        $this->assertTrue(Hash::check('passwordbaru1', $this->admin()->password));
        $this->assertAuthenticatedAs($this->admin());
    }

    public function test_reset_password_token_tidak_valid_ditolak(): void
    {
        $this->post('/password/reset', [
            'token' => 'token-palsu', 'email' => 'admin@peminjaman.test',
            'password' => 'passwordbaru1', 'password_confirmation' => 'passwordbaru1',
        ])->assertSessionHasErrors(['email' => 'This password reset token is invalid.']);

        $this->assertTrue(Hash::check('password', $this->admin()->password));
    }

    public function test_reset_password_validasi(): void
    {
        $token = Password::createToken($this->admin());
        $this->post('/password/reset', [
            'token' => $token, 'email' => 'bukan-email',
            'password' => '123', 'password_confirmation' => '456',
        ])->assertSessionHasErrors([
            'email' => 'The email must be a valid email address.',
            'password',
        ]);
    }

    public function test_reset_token_tidak_bisa_dipakai_dua_kali(): void
    {
        $token = Password::createToken($this->admin());
        $payload = ['token' => $token, 'email' => 'admin@peminjaman.test',
            'password' => 'passwordbaru1', 'password_confirmation' => 'passwordbaru1'];

        $this->post('/password/reset', $payload)->assertRedirect();
        auth()->logout();
        $this->post('/password/reset', ['password' => 'lagi12345', 'password_confirmation' => 'lagi12345'] + $payload)
            ->assertSessionHasErrors('email');
    }

    public function test_konfirmasi_password(): void
    {
        $this->get('/password/confirm')->assertRedirect('/login');

        $this->actingAsAdmin()->get('/password/confirm')->assertOk();

        $this->actingAsAdmin()->post('/password/confirm', ['password' => 'salah'])
            ->assertSessionHasErrors(['password' => 'The password is incorrect.']);

        $this->actingAsAdmin()->post('/password/confirm', ['password' => 'password'])
            ->assertRedirect()->assertSessionHas('auth.password_confirmed_at');
    }
}
