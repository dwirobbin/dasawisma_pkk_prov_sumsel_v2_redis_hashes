<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Dasawisma;
use App\Models\FamilyHead;
use Illuminate\Database\Seeder;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FamilyHeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ini_set('memory_limit', '2048M'); //allocate memory

        DB::disableQueryLog(); //disable log

        $dasawismaID = Dasawisma::query()->pluck('id');
        $createdByUserID = User::query()->where('role_id', 2)->pluck('id');

        $totalRecords = 1000000; // Desired total number of records to insert
        $recordsPerIteration = 50000; // Number of records to insert per inner loop iteration
        $outerLoopIterations = ceil($totalRecords / $recordsPerIteration); // Calculate number of outer loop iterations

        $newDataDefaultFamilies = []; // Array to store data to be inserted

        $this->command->getOutput()->progressStart($totalRecords);

        $recordsInserted = 0; // Counter for tracking inserted records

        for ($i = 0; $i < $outerLoopIterations; $i++) {
            for ($v = 0; $v < $recordsPerIteration; $v++) {
                $newDataDefaultFamilies[] = [
                    'dasawisma_id'  => $dasawismaID->random(),
                    'kk_number'     => fake()->unique()->numerify('################'),
                    'family_head'   => fake('ID_id')->unique()->name('male'),
                    'created_by'    => $createdByUserID->random(),
                ];
                $recordsInserted++;

                // Update the progress bar
                $this->command->getOutput()->progressAdvance();
            }

            $chunkData = array_chunk($newDataDefaultFamilies, 5000); // paginate data 5000
            foreach ($chunkData as $newDataDefaultFamily) {
                FamilyHead::query()->insert($newDataDefaultFamily);
            }

            unset($newDataDefaultFamilies); // Clear the array for the next batch of data
        }
        $this->command->getOutput()->progressFinish();
    }
}
