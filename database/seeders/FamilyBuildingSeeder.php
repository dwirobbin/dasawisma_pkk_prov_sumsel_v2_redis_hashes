<?php

namespace Database\Seeders;

use App\Models\FamilyBuilding;
use Illuminate\Database\Seeder;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FamilyBuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ini_set('memory_limit', '2048M'); //allocate memory

        DB::disableQueryLog(); //disable log

        $stapleFoodLists = ['Beras', 'Non Beras'];
        $waterSourceLists = [
            'PDAM',
            'Sumur',
            'Sungai',
            'Lainnya',
            'PDAM,Sumur',
            'PDAM,Sungai',
            'PDAM,Sumur,Sungai',
            'Sumur,Sungai',
        ];
        $houseCriteriaLists = ['Sehat', 'Kurang Sehat'];

        $totalRecords = 1000000; // Desired total number of records to insert
        $recordsPerIteration = 50000; // Number of records to insert per inner loop iteration
        $outerLoopIterations = ceil($totalRecords / $recordsPerIteration); // Calculate number of outer loop iterations

        $newDataDefaultFamilyBuildings = [];

        $this->command->getOutput()->progressStart($totalRecords);

        $recordsInserted = 1; // Counter for tracking inserted records

        for ($i = 0; $i < $outerLoopIterations; $i++) {
            for ($v = 0; $v < $recordsPerIteration; $v++) {
                $newDataDefaultFamilyBuildings[] = [
                    'family_head_id'        => $recordsInserted,
                    'staple_food'           => fake()->randomElement($stapleFoodLists),
                    'have_toilet'           => fake()->boolean(80),
                    'water_src'             => fake()->randomElement($waterSourceLists),
                    'have_landfill'         => fake()->boolean(80),
                    'have_sewerage'         => fake()->boolean(80),
                    'pasting_p4k_sticker'   => fake()->boolean(80),
                    'house_criteria'        => fake()->randomElement($houseCriteriaLists),
                ];
                $recordsInserted++;

                // Update the progress bar
                $this->command->getOutput()->progressAdvance();
            }

            $chunkData = array_chunk($newDataDefaultFamilyBuildings, 5000); // paginate data 5000
            foreach ($chunkData as $newDataDefaultFamilyBuilding) {
                FamilyBuilding::query()->insert($newDataDefaultFamilyBuilding);
            }

            unset($newDataDefaultFamilyBuildings); // Clear the array for the next batch of data
        }
        $this->command->getOutput()->progressFinish();
    }
}
