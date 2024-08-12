<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvData = fopen(base_path('database/seeders/csv/provinces.csv'), 'r');
        $firstline = true;

        while (($data = fgetcsv($csvData, 56, ',')) !== false) {
            if (!$firstline) {
                Province::create([
                    'id' => $data['0'],
                    'name' => $data['1'],
                    'slug' => $data['2'],
                    'capital_city' => $data['3'],
                    'area' => $data['4'],
                ]);
            }
            $firstline = false;
        }

        fclose($csvData);
    }
}
