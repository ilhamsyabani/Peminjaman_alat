<?php

namespace Tests\Feature\Smoke;

use App\Models\Member;
use App\Models\Post;
use App\Models\Transaction;
use PHPUnit\Framework\Attributes\DataProvider;

/**
 * Tamu (tidak login) harus diarahkan ke /login untuk semua fitur internal.
 */
class AccessControlTest extends SmokeTestCase
{
    public static function protectedGetRoutes(): array
    {
        return [
            'about' => ['/about'], 'users' => ['/users'], 'profile' => ['/profile'],
            'members' => ['/members'], 'members.create' => ['/members/create'],
            'products' => ['/products'], 'products.create' => ['/products/create'],
            'post' => ['/post'], 'post.create' => ['/post/create'],
            'dashboard' => ['/dashboard'], 'transactions' => ['/transactions'],
            'report.transaction' => ['/report/transaction'], 'report.member' => ['/report/member'],
            'report.product' => ['/report/product'],
            // Route di bawah ini TIDAK berada dalam middleware auth di routes/web.php
            'lokasi.index' => ['/country-state-city'],
            'search-member' => ['/search-member?search=a'],
            'search-product' => ['/search-product?search=a'],
            'search-no-result' => ['/search-no-result'],
        ];
    }

    #[DataProvider('protectedGetRoutes')]
    public function test_tamu_diarahkan_ke_login_untuk_get(string $uri): void
    {
        $this->get($uri)->assertRedirect('/login');
    }

    public static function protectedPostRoutes(): array
    {
        return [
            'transactions.store' => ['/transactions'],
            'transactions.approve' => ['/transactions/approve'],
            'transactions.return' => ['/transactions/return'],
            'transactions.return.product' => ['/transactions/return-product'],
            'members.store' => ['/members'],
            'products.store' => ['/products'],
            'post.store' => ['/post'],
            // Route mutasi tanpa middleware auth:
            'simpan.lokasi' => ['/location'],
            'simpan.ruang' => ['/room'],
            'simpan.lemari' => ['/locker'],
            'get-states' => ['/get-states-by-country'],
            'get-cities' => ['/get-cities-by-state'],
            'processmember' => ['/processmember'],
            'processproduct' => ['/processproduct'],
        ];
    }

    #[DataProvider('protectedPostRoutes')]
    public function test_tamu_diarahkan_ke_login_untuk_post(string $uri): void
    {
        $this->post($uri, ['name' => 'X', 'id' => 1])->assertRedirect('/login');
    }

    public function test_tamu_ditolak_untuk_route_berparameter(): void
    {
        $member = Member::first();
        $post = Post::first();
        $trx = Transaction::first();

        $this->get("/members/{$member->id}")->assertRedirect('/login');
        $this->put("/members/{$member->id}", [])->assertRedirect('/login');
        $this->delete("/members/{$member->id}")->assertRedirect('/login');
        $this->get("/post/{$post->slug}/edit")->assertRedirect('/login');
        $this->get("/transactions/{$trx->id}")->assertRedirect('/login');
        $this->get("/report/member/{$member->id}")->assertRedirect('/login');
        $this->put('/profile', [])->assertRedirect('/login');
    }

    public function test_tamu_tidak_dapat_mengubah_data_lewat_route_tanpa_auth(): void
    {
        $member = Member::where('status', 'tidak_ada')->first();
        $this->post('/processmember', ['id' => $member->id, 'status' => 'process']);
        $this->assertSame('tidak_ada', $member->fresh()->status, 'Tamu berhasil mengubah status member');
    }

    public function test_api_user_butuh_token_sanctum(): void
    {
        $this->getJson('/api/user')->assertUnauthorized();
        $token = $this->admin()->createToken('smoke')->plainTextToken;
        $this->withToken($token)->getJson('/api/user')->assertOk()->assertJsonPath('email', 'admin@peminjaman.test');
    }
}
