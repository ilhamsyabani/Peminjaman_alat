<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $title = fake('id_ID')->unique()->sentence(5);
        $content = fake('id_ID')->paragraphs(3, true);

        return [
            'title' => $title,
            'gambar' => null,
            'slug' => Str::slug($title),
            'category' => fake()->randomElement(['berita', 'pengumuman', 'panduan']),
            'content' => $content,
            'excerpt' => Str::limit($content, 120, '...'),
            'user_id' => User::factory(),
        ];
    }
}
