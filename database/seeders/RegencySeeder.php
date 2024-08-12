<?php

namespace Database\Seeders;

use App\Models\Regency;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RegencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvData = fopen(base_path('database/seeders/csv/regencies.csv'), 'r');
        $firstline = true;

        $regencies = [];
        while (($data = fgetcsv($csvData, 72, ',')) !== false) {
            if (!$firstline) {
                $regencies[] = [
                    'id' => $data['0'],
                    'name' => $data['1'],
                    'slug' => $data['2'],
                    'area' => $data['3'],
                    'province_id' => $data['4'],
                ];
            }
            $firstline = false;
        }

        foreach (array_chunk($regencies, 1000) as $regency) {
            Regency::insert($regency);
        }

        fclose($csvData);
    }
}
