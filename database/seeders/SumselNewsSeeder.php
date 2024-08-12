<?php

namespace Database\Seeders;

use App\Models\SumselNews;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SumselNewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SumselNews::factory(7)->create();
    }
}
