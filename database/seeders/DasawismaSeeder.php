<?php

namespace Database\Seeders;

use App\Models\Dasawisma;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DasawismaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 3; $i++) {
            Dasawisma::create([
                'name'          => 'Mawar',
                'province_id'   => 16, // Provinsi
                'regency_id'    => 1601, // OKU
                'district_id'   => 1601092, // Sinar Peninjauan
                'village_id'    => 1601092005, // Marga Mulya
                'rt'            => fake()->randomDigitNotNull(),
                'rw'            => fake()->randomDigitNotNull(),
            ]);
        }

        Dasawisma::factory(100)->create();
    }
}
