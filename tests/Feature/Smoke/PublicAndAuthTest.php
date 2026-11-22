<?php

namespace Tests\Feature\Smoke;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;

class PublicAndAuthTest extends SmokeTestCase
{
    public function test_halaman_publik_dapat_diakses_tamu(): void
    {
        $this->get('/')->assertOk()->assertSee('Tata Cara Peminjaman Barang Inventaris');
        $this->get('/login')->assertOk();
        $this->get('/register')->assertNotFound();
        $this->get('/daftar')->assertRedirect('/login');
        $this->get('/password/reset')->assertOk();
    }

    public function test_halaman_blog_detail_dengan_navigasi(): void
    {
        $post = Post::orderBy('id')->skip(1)->first();
        $this->get(route('blog.post', $post))->assertOk()->assertSee($post->title);
    }

    public function test_blog_dengan_post_tidak_ada_mengembalikan_404(): void
    {
        $this->get('/blog/999999')->assertNotFound();
    }

    public function test_user_login_diarahkan_dari_halaman_login(): void
    {
        $this->actingAsAdmin()->get('/login')->assertRedirect();
    }

    public function test_login_berhasil_dan_gagal(): void
    {
        $this->post('/login', ['email' => 'admin@peminjaman.test', 'password' => 'password'])
            ->assertRedirect('dashboard');
        $this->assertAuthenticated();

        auth()->logout();

        $this->post('/login', ['email' => 'admin@peminjaman.test', 'password' => 'salah'])
            ->assertSessionHasErrors(['email' => 'These credentials do not match our records.']);
        $this->assertGuest();
    }

    public function test_logout(): void
    {
        $this->actingAsAdmin()->post('/logout')->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_registrasi_publik_ditutup(): void
    {
        $this->post('/register', [
            'name' => 'Rina Marlina', 'email' => 'rina@mail.test',
            'password' => 'rahasia123', 'password_confirmation' => 'rahasia123',
        ])->assertNotFound();
        $this->assertDatabaseMissing('users', ['email' => 'rina@mail.test']);
    }

    public function test_lupa_password_mengirim_notifikasi_dengan_fake(): void
    {
        Notification::fake();
        $this->post('/password/email', ['email' => 'admin@peminjaman.test'])->assertSessionHas('status');
        Notification::assertSentTo(User::where('email', 'admin@peminjaman.test')->first(), ResetPassword::class);
    }
}
