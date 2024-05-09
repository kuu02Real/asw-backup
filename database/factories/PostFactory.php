<?php

namespace Database\Factories;

use App\Models\Community;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence,
            'content' => fake()->text,
            'likes' => fake()->numberBetween(0, 100),
            'dislikes' => fake()->numberBetween(0, 100),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Post $post) {
            // Asociar el post con una comunidad
            $community = Community::factory()->create();
            $post->community()->associate($community)->save();
        });
    }
}
