<?php

namespace Database\Factories;

use App\Models\Regency;
use App\Models\Village;
use App\Models\District;
use App\Models\Province;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dasawisma>
 */
class DasawismaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake('ID_id')->unique()->words(2, true);

        $randomVillageId = fake()->randomElement(Village::pluck('id')->toArray());

        $village = Village::where('id', '=', $randomVillageId)->first(['id', 'district_id']);
        $district = District::where('id', '=', $village->district_id)->first(['id', 'regency_id']);
        $regency = Regency::where('id', '=', $district->regency_id)->first(['id', 'province_id']);
        $province = Province::where('id', '=', $regency->province_id)->first(['id']);

        return [
            'name'          => str($name)->title(),
            'slug'          => $name,
            'province_id'   => $province->id,
            'regency_id'    => $regency->id,
            'district_id'   => $district->id,
            'village_id'    => $village->id,
            'rt'            => fake()->randomDigitNotNull(),
            'rw'            => fake()->randomDigitNotNull(),
        ];
    }
}
