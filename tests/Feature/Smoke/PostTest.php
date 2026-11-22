<?php

namespace Tests\Feature\Smoke;

use App\Models\Post;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PostTest extends SmokeTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake();
    }

    public function test_index_create_edit(): void
    {
        $post = Post::first();
        $this->actingAsAdmin()->get('/post')->assertOk()->assertSee($post->title);
        $this->actingAsAdmin()->get('/post/create')->assertOk();
        $this->actingAsAdmin()->get("/post/{$post->id}/edit")->assertOk()->assertSee($post->title);
    }

    public function test_index_pencarian(): void
    {
        $this->actingAsAdmin()->get('/post?search=Jadwal')->assertOk()->assertSee('Jadwal Libur Layanan');
    }

    public function test_show_post(): void
    {
        $post = Post::first();
        $this->actingAsAdmin()->get("/post/{$post->id}")->assertOk()->assertSee($post->title);
    }

    public function test_store_post_dengan_gambar(): void
    {
        $this->actingAsAdmin()->post('/post', [
            'title' => 'Pengumuman Stok Opname', 'category' => 'pengumuman',
            'content' => 'Stok opname dilaksanakan setiap akhir bulan.',
            'gambar' => UploadedFile::fake()->image('opname.jpg'),
        ])->assertRedirect();

        $post = Post::where('slug', 'pengumuman-stok-opname')->firstOrFail();
        $this->assertSame($this->admin()->id, $post->user_id);
        $this->assertNotNull($post->gambar, 'Gambar diunggah tetapi tidak disimpan ke kolom gambar');
        $this->assertStringStartsWith('img-', (string) $post->gambar, "Kolom gambar berisi path yang salah: {$post->gambar}");
        Storage::assertExists($post->gambar);
    }

    public function test_store_post_validasi(): void
    {
        $this->actingAsAdmin()->post('/post', ['title' => str_repeat('a', 256)])
            ->assertSessionHasErrors([
                'title' => 'The title must not be greater than 255 characters.',
                'category' => 'The category field is required.',
                'content' => 'The content field is required.',
            ]);
        $this->actingAsAdmin()->post('/post', [
            'title' => 'X', 'category' => 'x', 'content' => 'x',
            'gambar' => UploadedFile::fake()->create('virus.pdf', 10, 'application/pdf'),
        ])->assertSessionHasErrors(['gambar' => 'The gambar must be an image.']);
    }

    public function test_update_post_dengan_judul_sama_mempertahankan_slug(): void
    {
        $post = Post::first();
        $this->actingAsAdmin()->put("/post/{$post->id}", [
            'title' => $post->title, 'category' => 'panduan', 'content' => 'Isi diperbarui.',
        ])->assertRedirect();
        $this->assertSame($post->slug, $post->fresh()->slug);
        $this->assertSame('Isi diperbarui.', $post->fresh()->content);
    }

    public function test_update_post_excerpt_dipotong_120_karakter(): void
    {
        $post = Post::first();
        $this->actingAsAdmin()->put("/post/{$post->id}", [
            'title' => 'Judul Baru', 'category' => 'panduan', 'content' => str_repeat('kata ', 100),
        ])->assertRedirect();
        $this->assertSame('Judul Baru', $post->fresh()->title);
        $this->assertLessThanOrEqual(123, mb_strlen($post->fresh()->excerpt));
    }

    public function test_hapus_post(): void
    {
        $post = Post::first();
        $this->actingAsAdmin()->delete("/post/{$post->id}")->assertRedirect();
        $this->assertModelMissing($post);
    }
}
