<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FrameworkUpgradeSmokeTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_and_authenticated_pages_render_after_upgrade(): void
    {
        $this->get('/')->assertOk();
        $this->get('/login')->assertOk();

        $this->actingAs(User::factory()->create());

        foreach (['users.index', 'members.index', 'products.index', 'post.index', 'transactions.index'] as $route) {
            $this->get(route($route))->assertOk();
        }
    }

    public function test_post_creation_still_generates_slug(): void
    {
        $this->actingAs(User::factory()->create())
            ->post(route('post.store'), [
                'title' => 'Peminjaman Ruang Baru',
                'category' => 'berita',
                'content' => 'Informasi peminjaman ruang.',
            ])
            ->assertRedirect();

        $this->assertSame('peminjaman-ruang-baru', Post::firstOrFail()->slug);
    }

    public function test_user_can_log_in_with_laravel_ui_after_upgrade(): void
    {
        $user = User::factory()->create();

        $this->post('/login', ['email' => $user->email, 'password' => 'password'])
            ->assertRedirect('dashboard');

        $this->assertAuthenticatedAs($user);
    }

    public function test_sanctum_api_token_still_authenticates(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('upgrade-smoke')->plainTextToken;

        $this->withToken($token)->getJson('/api/user')
            ->assertOk()
            ->assertJsonPath('id', $user->id);
    }
}
