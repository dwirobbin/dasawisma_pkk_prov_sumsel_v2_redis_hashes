<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultPermissions = [
            // Profile
            ['title' => 'Profile', 'name' => 'Show Profile', 'slug' => 'show-profile'],
            ['title' => 'Profile', 'name' => 'Update Profile', 'slug' => 'update-profile'],
            // Dashboard
            ['title' => 'Dashboard', 'name' => 'Show Dashboard', 'slug' => 'show-dashboard'],
            // Dasawisma
            ['title' => 'Dasawisma', 'name' => 'Create Dasawisma', 'slug' => 'create-dasawisma'],
            ['title' => 'Dasawisma', 'name' => 'Show Dasawisma', 'slug' => 'show-dasawisma'],
            ['title' => 'Dasawisma', 'name' => 'Update Dasawisma ', 'slug' => 'update-dasawisma'],
            ['title' => 'Dasawisma', 'name' => 'Delete Dasawisma ', 'slug' => 'delete-dasawisma'],
            // Dasawisma Activities
            ['title' => 'Kegiatan Dasawisma', 'name' => 'Create Dasawisma Activity', 'slug' => 'create-dasawisma-activity'],
            ['title' => 'Kegiatan Dasawisma', 'name' => 'Show Dasawisma Activity', 'slug' => 'show-dasawisma-activity'],
            ['title' => 'Kegiatan Dasawisma', 'name' => 'Update Dasawisma Activity ', 'slug' => 'update-dasawisma-activity'],
            ['title' => 'Kegiatan Dasawisma', 'name' => 'Delete Dasawisma Activity ', 'slug' => 'delete-dasawisma-activity'],
            // Sumsel News
            ['title' => 'Berita Sumsel', 'name' => 'Create Sumsel News', 'slug' => 'create-sumsel-news'],
            ['title' => 'Berita Sumsel', 'name' => 'Show Sumsel News', 'slug' => 'show-sumsel-news'],
            ['title' => 'Berita Sumsel', 'name' => 'Update Sumsel News ', 'slug' => 'update-sumsel-news'],
            ['title' => 'Berita Sumsel', 'name' => 'Delete Sumsel News ', 'slug' => 'delete-sumsel-news'],
            // User
            ['title' => 'User', 'name' => 'Create User', 'slug' => 'create-user'],
            ['title' => 'User', 'name' => 'Show User', 'slug' => 'show-user'],
            ['title' => 'User', 'name' => 'Update User ', 'slug' => 'update-user'],
            ['title' => 'User', 'name' => 'Delete User ', 'slug' => 'delete-user'],
            // Role
            ['title' => 'Role', 'name' => 'Create Role', 'slug' => 'create-role'],
            ['title' => 'Role', 'name' => 'Show Role', 'slug' => 'show-role'],
            ['title' => 'Role', 'name' => 'Update Role ', 'slug' => 'update-role'],
            ['title' => 'Role', 'name' => 'Delete Role ', 'slug' => 'delete-role'],
            // Permission
            ['title' => 'Permission', 'name' => 'Create Permission', 'slug' => 'create-permission'],
            ['title' => 'Permission', 'name' => 'Show Permission', 'slug' => 'show-permission'],
            ['title' => 'Permission', 'name' => 'Update Permission ', 'slug' => 'update-permission'],
            ['title' => 'Permission', 'name' => 'Delete Permission ', 'slug' => 'delete-permission'],
        ];

        Permission::insert($defaultPermissions);
    }
}
