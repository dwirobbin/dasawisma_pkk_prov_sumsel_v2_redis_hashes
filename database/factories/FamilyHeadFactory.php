<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Dasawisma;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FamilyHead>
 */
class FamilyHeadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randDasawismaId = Arr::random(Dasawisma::query()->pluck('id')->toArray());
        $randUserId = Arr::random(User::query()->pluck('id')->toArray());

        return [
            'dasawisma_id' => $randDasawismaId,
            'kk_number' => fake('ID_id')->unique()->numerify('################'),
            'family_head' => fake('ID_id')->unique()->name(),
            'created_by' => $randUserId,
        ];
    }
}
