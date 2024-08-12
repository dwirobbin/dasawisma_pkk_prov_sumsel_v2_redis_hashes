<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DasawismaActivity>
 */
class DasawismaActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake('ID_id')->sentence(7, false);

        return [
            'title' => str($title)->title(),
            'slug' => str($title)->slug(),
            'body' => fake()->paragraphs(10, true),
            'author_id' => User::inRandomOrder()->whereNotIn('id', [1, 9])->first()->id,
            'is_published' => fake()->boolean(75),
        ];
    }
}
