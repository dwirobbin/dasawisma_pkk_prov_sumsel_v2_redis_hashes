<?php

namespace Database\Seeders;

use App\Models\FamilyActivity;
use Illuminate\Database\Seeder;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FamilyActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ini_set('memory_limit', '2048M'); //allocate memory

        DB::disableQueryLog(); //disable log

        $up2kActivities = [
            'Usaha Warung',
            'Usaha Toko',
            'Usaha Kuliner',
            'Usaha Online (E-commerce)',
            'Jasa kebersihan',
            'Jual Tanaman Hias',
            'Katering',
            'Menjual Kerajinan Tangan',
            'Menjual Kue,Roti dan Minuman',
            'Jasa Konsultasi atau Penasihat',
            'Jasa Instruktur Kebugaran',
            'Jasa Desain Grafis atau Web',
            'Jasa Sewa Penginapan',
            'Jasa Pemeliharaan Kendaraan',
        ];

        $envHealthActivities = [
            'Kerja bakti atau gotong royong',
            'Membuat tempat sampah',
            'Membuang sampah pada tempatnya',
            'Menyelenggarakan kegiatan penanaman pohon dan tumbuhan',
            'Membuat pupuk dari sampah organik',
            'Tidak sembarang membakar sampah',
        ];

        $totalRecords = 1000000; // Desired total number of records to insert
        $recordsPerIteration = 50000; // Number of records to insert per inner loop iteration
        $outerLoopIterations = ceil($totalRecords / $recordsPerIteration); // Calculate number of outer loop iterations

        $newDataDefaultFamilyActivities = [];

        $this->command->getOutput()->progressStart($totalRecords);

        $recordsInserted = 1; // Counter for tracking inserted records

        for ($i = 0; $i < $outerLoopIterations; $i++) {
            for ($v = 0; $v < $recordsPerIteration; $v++) {
                $newDataDefaultFamilyActivities[] = [
                    'family_head_id'        => $recordsInserted,
                    'up2k_activity'         => fake()->randomElement($up2kActivities),
                    'env_health_activity'   => fake()->randomElement($envHealthActivities),
                ];
                $recordsInserted++;

                // Update the progress bar
                $this->command->getOutput()->progressAdvance();
            }

            $chunkData = array_chunk($newDataDefaultFamilyActivities, 5000); // paginate data 1000
            foreach ($chunkData as $newDataDefaultFamilyActivity) {
                FamilyActivity::query()->insert($newDataDefaultFamilyActivity);
            }

            unset($newDataDefaultFamilyActivities); // Clear the array for the next batch of data
        }
        $this->command->getOutput()->progressFinish();
    }
}
