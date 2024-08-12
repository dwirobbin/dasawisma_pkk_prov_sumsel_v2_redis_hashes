<?php

namespace Database\Seeders;

use App\Models\UserCommentSumselNews;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserCommentSumselNewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserCommentSumselNews::factory(8)->create();
    }
}
