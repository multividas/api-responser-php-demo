<?php

namespace Database\Factories;

use App\Models\User;
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
            'title' => fake()->sentence($nbWords = 4),
            'content' => fake()->text($maxNbChars = 500),
            'user_id' => User::all()->random()->id,
            'created_at' => fake()->dateTimeBetween('-3 weeks')
        ];
    }
}
