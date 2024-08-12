<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\AdminSeeder;
use Database\Seeders\RegencySeeder;
use Database\Seeders\VillageSeeder;
use Database\Seeders\DistrictSeeder;
use Database\Seeders\ProvinceSeeder;
use Illuminate\Support\Facades\File;
use Database\Seeders\DasawismaSeeder;
use Database\Seeders\FamilyHeadSeeder;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\SumselNewsSeeder;
use Illuminate\Support\Facades\Storage;
use Database\Seeders\FamilyMemberSeeder;
use Database\Seeders\FamilyActivitySeeder;
use Database\Seeders\FamilyBuildingSeeder;
use Database\Seeders\FamilySizeMemberSeeder;
use Database\Seeders\DasawismaActivitySeeder;
use Database\Seeders\UserCommentSumselNewsSeeder;
use Database\Seeders\UserCommentDasawismaActivitySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // echo "" > 'storage/logs/laravel.log';

        // $pathSession = storage_path('framework/sessions');
        // $ignoreFiles = ['.gitignore', '.', '..'];
        // $sessionFiles = scandir($pathSession);
        // foreach ($sessionFiles as $sessionFile) {
        //     if (!in_array($sessionFile, $ignoreFiles)) unlink($pathSession . '/' . $sessionFile);
        // }

        $livewireTmpFiles = Storage::allFiles('livewire-tmp');
        foreach ($livewireTmpFiles as $livewireTmpFile) {
            Storage::delete($livewireTmpFile);
        }

        $imageFilepath = 'image';

        $pathDasawismaActivity = $imageFilepath . '/dasawisma-activities';
        if (Storage::disk('public')->directoryExists($pathDasawismaActivity)) {
            Storage::disk('public')->deleteDirectory($pathDasawismaActivity);
        }

        $pathSumselNews = $imageFilepath . '/sumsel-news';
        if (Storage::disk('public')->directoryExists($pathSumselNews)) {
            Storage::disk('public')->deleteDirectory($pathSumselNews);
        }

        $pathProfile = $imageFilepath . '/profiles';
        if (Storage::disk('public')->directoryExists($pathProfile)) {
            Storage::disk('public')->deleteDirectory($pathProfile);
        }

        $this->call([
            ProvinceSeeder::class,
            RegencySeeder::class,
            DistrictSeeder::class,
            VillageSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            AdminSeeder::class,
            DasawismaActivitySeeder::class,
            SumselNewsSeeder::class,
            UserCommentDasawismaActivitySeeder::class,
            UserCommentSumselNewsSeeder::class,
            DasawismaSeeder::class,

            FamilyHeadSeeder::class,
            FamilyBuildingSeeder::class,
            FamilySizeMemberSeeder::class,
            FamilyActivitySeeder::class,

            // FamilyMemberSeeder::class,
        ]);
    }
}
