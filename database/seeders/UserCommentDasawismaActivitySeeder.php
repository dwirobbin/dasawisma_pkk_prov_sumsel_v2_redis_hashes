<?php

namespace Database\Seeders;

use App\Models\UserCommentDasawismaActivity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserCommentDasawismaActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserCommentDasawismaActivity::factory(8)->create();
    }
}
