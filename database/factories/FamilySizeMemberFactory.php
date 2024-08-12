<?php

namespace Database\Factories;

use App\Models\FamilyHead;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FamilySizeMember>
 */
class FamilySizeMemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randFamilyHeadId = array_rand(FamilyHead::query()->pluck('id')->toArray());

        return [
            'family_head_id'                => $randFamilyHeadId,
            'toddlers_number'               => fake()->optional(0.8, 0)->randomDigitNotNull(),
            'pus_number'                    => fake()->optional(0.8, 0)->randomDigitNotNull(),
            'wus_number'                    => fake()->optional(0.8, 0)->randomDigitNotNull(),
            'blind_people_number'           => fake()->optional(0.8, 0)->randomDigitNotNull(),
            'pregnant_women_number'         => fake()->optional(0.8, 0)->randomDigitNotNull(),
            'breastfeeding_mother_number'   => fake()->optional(0.8, 0)->randomDigitNotNull(),
            'elderly_number'                => fake()->optional(0.8, 0)->randomDigitNotNull(),
        ];
    }
}
