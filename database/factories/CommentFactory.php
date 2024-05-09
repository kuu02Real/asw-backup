<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Post;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ids_users = User::pluck('id');
        $ids_posts = Post::pluck('id');
        return [
            'content' => fake()->text,
            'user_id' => fake()->randomElement($ids_users),
            'likes' => fake()->numberBetween(0, 100),
            'dislikes' => fake()->numberBetween(0, 100),
            'post_id' => fake()->randomElement($ids_posts),
            'edited' => false,
        ];
    }
}
