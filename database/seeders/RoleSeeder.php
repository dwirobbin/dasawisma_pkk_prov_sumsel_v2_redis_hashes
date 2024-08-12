<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultRoles = [
            ['name' => 'Super Admin', 'slug' => 'super-admin'],
            ['name' => 'Admin', 'slug' => 'admin'],
            ['name' => 'Guest', 'slug' => 'guest'],
        ];

        Role::insert($defaultRoles);

        // Role has Permission
        Role::whereKey([1, 2])->get()->map(function ($role) { // Super Admin, Admin
            return $role->permissions()->attach([
                1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27
            ]);
        });
        Role::find(3)->permissions()->attach([1, 3, 5, 9, 13, 17]); // Guest
    }
}
