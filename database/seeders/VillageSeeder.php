<?php

namespace Database\Seeders;

use App\Models\Village;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VillageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvData = fopen(base_path('database/seeders/csv/villages.csv'), 'r');
        $firstline = true;

        $villages = [];
        while (($data = fgetcsv($csvData, 96, ',')) !== false) {
            if (!$firstline) {
                $villages[] = [
                    'id' => $data['0'],
                    'name' => $data['1'],
                    'slug' => $data['2'],
                    'area' => $data['3'],
                    'district_id' => $data['4'],
                ];
            }
            $firstline = false;
        }

        foreach (array_chunk($villages, 1000) as $village) {
            Village::insert($village);
        }

        fclose($csvData);
    }
}
