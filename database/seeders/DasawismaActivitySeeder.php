<?php

namespace Database\Seeders;

use App\Models\DasawismaActivity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DasawismaActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DasawismaActivity::factory(7)->create();
    }
}
