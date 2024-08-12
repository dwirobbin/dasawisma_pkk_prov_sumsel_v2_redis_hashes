<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FamilySizeMember;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FamilySizeMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ini_set('memory_limit', '2048M'); //allocate memory

        DB::disableQueryLog(); //disable log

        $totalRecords = 1000000; // Desired total number of records to insert
        $recordsPerIteration = 50000; // Number of records to insert per inner loop iteration
        $outerLoopIterations = ceil($totalRecords / $recordsPerIteration); // Calculate number of outer loop iterations

        $newDataDefaultFamilyNumbers = [];

        $this->command->getOutput()->progressStart($totalRecords);

        $recordsInserted = 1; // Counter for tracking inserted records

        for ($i = 0; $i < $outerLoopIterations; $i++) {
            for ($v = 0; $v < $recordsPerIteration; $v++) {
                $newDataDefaultFamilyNumbers[] = [
                    'family_head_id'                => $recordsInserted,
                    'toddlers_number'               => fake()->optional(0.8, 0)->randomDigitNotNull(),
                    'pus_number'                    => fake()->optional(0.8, 0)->randomDigitNotNull(),
                    'wus_number'                    => fake()->optional(0.8, 0)->randomDigitNotNull(),
                    'blind_people_number'           => fake()->optional(0.8, 0)->randomDigitNotNull(),
                    'pregnant_women_number'         => fake()->optional(0.8, 0)->randomDigitNotNull(),
                    'breastfeeding_mother_number'   => fake()->optional(0.8, 0)->randomDigitNotNull(),
                    'elderly_number'                => fake()->optional(0.8, 0)->randomDigitNotNull(),
                ];
                $recordsInserted++;

                // Update the progress bar
                $this->command->getOutput()->progressAdvance();
            }

            $chunkData = array_chunk($newDataDefaultFamilyNumbers, 5000); // paginate data 5000
            foreach ($chunkData as $newDataDefaultFamilyNumber) {
                FamilySizeMember::query()->insert($newDataDefaultFamilyNumber);
            }

            unset($newDataDefaultFamilyNumbers); // Clear the array for the next batch of data
        }
        $this->command->getOutput()->progressFinish();
    }
}
