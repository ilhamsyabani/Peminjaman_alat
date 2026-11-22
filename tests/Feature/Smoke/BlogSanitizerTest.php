<?php

namespace Tests\Feature\Smoke;

use App\Models\Post;
use PHPUnit\Framework\Attributes\DataProvider;

class BlogSanitizerTest extends SmokeTestCase
{
    public static function xssPayloads(): array
    {
        return [
            'script' => ['<script>alert(1)</script>', '<script'],
            'img onerror' => ['<img src=x onerror="alert(1)">', 'onerror'],
            'a javascript:' => ['<a href="javascript:alert(1)">klik</a>', 'javascript:'],
            'svg onload' => ['<svg onload=alert(1)></svg>', 'onload'],
            'iframe' => ['<iframe src="https://evil.test"></iframe>', '<iframe'],
            'style tag' => ['<style>body{display:none}</style>', '<style'],
            'div onclick' => ['<div onclick="alert(1)">x</div>', 'onclick'],
            'data: uri' => ['<a href="data:text/html;base64,PHNjcmlwdD4=">x</a>', 'data:text/html'],
            'uppercase' => ['<SCRIPT>alert(1)</SCRIPT>', 'alert(1)</'],
        ];
    }

    #[DataProvider('xssPayloads')]
    public function test_payload_xss_dinetralkan(string $payload, string $forbidden): void
    {
        $post = Post::first();
        $post->update(['content' => "<div>Aman</div>{$payload}"]);

        $html = $this->get(route('blog.post', $post))->assertOk()->getContent();
        // hanya isi <section class="post-content">, bukan script milik layout
        $this->assertSame(1, preg_match('#<section class="post-content">(.*?)</section>#s', $html, $m));
        $body = $m[1];
        $this->assertStringNotContainsStringIgnoringCase($forbidden, $body);
    }

    public function test_format_trix_yang_sah_dipertahankan(): void
    {
        $post = Post::first();
        $post->update(['content' => '<div><strong>Tebal</strong> <em>miring</em><br><a href="https://kampus.ac.id">tautan</a></div><ul><li>satu</li></ul>']);

        $this->get(route('blog.post', $post))->assertOk()
            ->assertSee('<strong>Tebal</strong>', false)
            ->assertSee('<em>miring</em>', false)
            ->assertSee('href="https://kampus.ac.id"', false)
            ->assertSee('<li>satu</li>', false);
    }
}
