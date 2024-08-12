<?php

namespace Database\Factories;

use App\Models\FamilyHead;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FamilyBuilding>
 */
class FamilyBuildingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randFamilyHeadId = array_rand(FamilyHead::query()->pluck('id')->toArray());

        $stapleFoodLists = ['Beras', 'Non Beras'];

        $waterSourceLists = [
            'PDAM', 'Sumur', 'Sungai', 'Lainnya',  'PDAM,Sumur',
            'PDAM,Sungai', 'PDAM,Sumur,Sungai', 'Sumur,Sungai',
        ];

        $houseCriteriaLists = ['Sehat', 'Kurang Sehat'];

        return [
            'family_head_id'        => $randFamilyHeadId,
            'staple_food'           => fake()->randomElement($stapleFoodLists),
            'have_toilet'           => fake()->boolean(80),
            'water_src'             => fake()->randomElement($waterSourceLists),
            'have_landfill'         => fake()->boolean(80),
            'have_sewerage'         => fake()->boolean(80),
            'pasting_p4k_sticker'   => fake()->boolean(80),
            'house_criteria'        => fake()->randomElement($houseCriteriaLists),
        ];
    }
}
