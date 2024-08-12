<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvData = fopen(base_path('database/seeders/csv/districts.csv'), 'r');
        $firstline = true;

        $districts = [];
        while (($data = fgetcsv($csvData, 87, ',')) !== false) {
            if (!$firstline) {
                $districts[] = [
                    'id' => $data['0'],
                    'name' => $data['1'],
                    'slug' => $data['2'],
                    'area' => $data['3'],
                    'regency_id' => $data['4'],
                ];
            }
            $firstline = false;
        }

        foreach (array_chunk($districts, 1000) as $district) {
            District::insert($district);
        }

        fclose($csvData);
    }
}
