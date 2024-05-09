<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Community>
 */
class CommunityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            'name' => fake()->sentence,
            'image' => '/images/whiteVan.jpeg',
            'banner' => '/images/seat_ibiza_marronero.jpg',
            'idComm' => fake()->unique->numberBetween(1, 50)
        ];
    }
}
