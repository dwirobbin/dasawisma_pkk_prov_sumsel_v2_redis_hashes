<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FamilyMember>
 */
class FamilyMemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake('ID_id')->unique()->name();

        $maritalStatuses = ['Kawin'];

        $lastEducations = [
            'SD/MI', 'SLTP/SMP/MTS', 'SLTA/SMA/MA/SMK', 'Diploma', 'S1', 'S2', 'S3',
        ];

        return [
            'nik_number'        => fake('ID_id')->nik(),
            'name'              => str($name)->title(),
            'slug'              => str($name)->slug(),
            'birth_date'        => fake()->date(),
            'marital_status'    => fake()->randomElement($maritalStatuses),
            'last_education'    => fake()->randomElement($lastEducations),
            'profession'        => fake('ID_id')->optional(0.8, 'Belum/Tidak Bekerja')->jobTitle(),
        ];
    }
}
