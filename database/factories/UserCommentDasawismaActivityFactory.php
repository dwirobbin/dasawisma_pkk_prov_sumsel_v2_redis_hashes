<?php

namespace Database\Factories;

use App\Models\DasawismaActivity;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserCommentDasawismaActivity>
 */
class UserCommentDasawismaActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => rand(1, 9),
            'body' => fake()->words(rand(5, 10), true),
            'dasawisma_activity_id' => DasawismaActivity::inRandomOrder()->whereIsPublished(true)->value('id'),
        ];
    }
}
