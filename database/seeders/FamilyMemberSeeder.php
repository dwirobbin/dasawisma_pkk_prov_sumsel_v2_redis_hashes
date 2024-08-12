<?php

namespace Database\Seeders;

use App\Models\FamilyBuilding;
use App\Models\FamilyHead;
use App\Models\FamilyMember;
use App\Models\FamilySizeMember;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FamilyMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ini_set('memory_limit', '3072M'); //allocate memory
        // ini_set('memory_limit', '4096M'); //allocate memory

        DB::disableQueryLog(); //disable log

        $lastEducations = ['SD/MI', 'SLTP/SMP/MTS', 'SLTA/SMA/MA/SMK', 'Diploma', 'S1', 'S2', 'S3'];

        $totalRecords = 1000000; // Desired total number of records to insert
        $recordsPerIteration = 50000; // Number of records to insert per inner loop iteration
        $outerLoopIterations = ceil($totalRecords / $recordsPerIteration); // Calculate number of outer loop iterations

        $newDataDefaultFamilyMembers = [];

        $this->command->getOutput()->progressStart($totalRecords);

        $recordsInserted = 0; // Counter for tracking inserted records

        // $familyHeads = DB::select("select id, family_head from family_heads");

        $familyHeadIdForWife = 1;
        for ($i = 0; $i < $outerLoopIterations; $i++) {
            for ($v = 0; $v < $recordsPerIteration; $v++) {
                // if ($recordsInserted < 4000000) {
                // $newDataDefaultFamilyMembers[] = [
                //     'family_head_id'    => $familyHeads[$recordsInserted]->id,
                //     'nik_number'        => fake('ID_id')->nik(),
                //     'name'              => $familyHeads[$recordsInserted]->family_head,
                //     'slug'              => str($familyHeads[$recordsInserted]->family_head)->slug(),
                //     'birth_date'        => fake()->date(),
                //     'status'            => 'Kepala Keluarga',
                //     'gender'            => 'Laki-laki',
                //     'marital_status'    => 'Kawin',
                //     'last_education'    => fake()->randomElement($lastEducations),
                //     'profession'        => fake('ID_id')->optional(0.8, 'Belum/Tidak Bekerja')->jobTitle(),
                // ];
                // }

                // if ($recordsInserted >= 4000001) {
                $name = fake('ID_id')->unique()->name('female');
                $newDataDefaultFamilyMembers[] = [
                    'family_head_id'    => $familyHeadIdForWife,
                    'nik_number'        => fake('ID_id')->nik(),
                    'name'              => str($name)->title(),
                    'slug'              => str($name)->slug(),
                    'birth_date'        => fake()->date(),
                    'status'            => 'Istri',
                    'gender'            => 'Perempuan',
                    'marital_status'    => 'Kawin',
                    'last_education'    => fake()->randomElement($lastEducations),
                    'profession'        => 'Ibu Rumah Tangga',
                    // 'profession'        => fake('ID_id')->optional(0.8, 'Belum/Tidak Bekerja')->jobTitle(),
                ];

                $familyHeadIdForWife++;
                // }

                // $recordsInserted++;

                $this->command->getOutput()->progressAdvance();
            }

            $chunkData = array_chunk($newDataDefaultFamilyMembers, 5000); // paginate data 5000
            foreach ($chunkData as $newDataDefaultFamilyMember) {
                FamilyMember::insert($newDataDefaultFamilyMember);
            }

            unset($newDataDefaultFamilyMembers); // Clear the array for the next batch of data
        }
        $this->command->getOutput()->progressFinish();
    }
}
