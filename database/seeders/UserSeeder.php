<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dateTime = DB::select("SELECT NOW() AS date_time");

        $defaultUsers = [
            // Super Admin
            [
                'name'              => 'Super Admin',
                'username'          => 'superadmin',
                'email'             => 'superadmin@gmail.com',
                'email_verified_at' => $dateTime[0]->date_time,
                'password'          => Hash::make('password'),
                'remember_token'    => Str::random(10),
                'photo'             => null,
                'role_id'           => 1,
                'is_active'         => true,
            ],

            // Admin Provinsi SumSel
            [
                'name'              => 'Admin Prov. Sumsel',
                'username'          => 'adminprov.sumsel',
                'email'             => 'adminprov.sumsel@gmail.com',
                'email_verified_at' => $dateTime[0]->date_time,
                'password'          => Hash::make('password'),
                'remember_token'    => Str::random(10),
                'photo'             => null,
                'role_id'           => 2,
                'is_active'         => true,
            ],

            // Admin Kota Sumsel -> Palembang
            [
                'name'              => 'Admin Kota Palembang',
                'username'          => 'adminkotapalembang',
                'email'             => 'adminkotapalembang@gmail.com',
                'email_verified_at' => $dateTime[0]->date_time,
                'password'          => Hash::make('password'),
                'remember_token'    => Str::random(10),
                'photo'             => null,
                'role_id'           => 2,
                'is_active'         => true,
            ],

            // Admin Kecamatan Palembang -> Jakabaring
            [
                'name'              => 'Admin Kec. Jakabaring',
                'username'          => 'adminkec.jakabaring',
                'email'             => 'adminkec.jakabaring@gmail.com',
                'email_verified_at' => $dateTime[0]->date_time,
                'password'          => Hash::make('password'),
                'remember_token'    => Str::random(10),
                'photo'             => null,
                'role_id'           => 2,
                'is_active'         => true,
            ],

            // Admin Kelurahan Palembang -> Jakabaring -> Silaberanti
            [
                'name'              => 'Admin Kel. Silaberanti',
                'username'          => 'adminkel.silaberanti',
                'email'             => 'adminkel.silaberanti@gmail.com',
                'email_verified_at' => $dateTime[0]->date_time,
                'password'          => Hash::make('password'),
                'remember_token'    => Str::random(10),
                'photo'             => null,
                'role_id'           => 2,
                'is_active'         => true,
            ],

            // Admin Kabupaten Ogan Komering Ulu
            [
                'name'              => 'Admin Kab. OKU',
                'username'          => 'adminkab.oku',
                'email'             => 'adminkab.oku@gmail.com',
                'email_verified_at' => $dateTime[0]->date_time,
                'password'          => Hash::make('password'),
                'remember_token'    => Str::random(10),
                'photo'             => null,
                'role_id'           => 2,
                'is_active'         => true,
            ],

            // Admin Kecamatan OKU -> Sinar Peninjauan
            [
                'name'              => 'Admin Kec. Sinar Peninjauan',
                'username'          => 'adminkec.sinarpeninjauan',
                'email'             => 'adminkec.sinarpeninjauan@gmail.com',
                'email_verified_at' => $dateTime[0]->date_time,
                'password'          => Hash::make('password'),
                'remember_token'    => Str::random(10),
                'photo'             => null,
                'role_id'           => 2,
                'is_active'         => true,
            ],

            // Admin Kelurahan OKU -> Sinar Peninjauan -> Marga Mulya
            [
                'name'              => 'Admin Kel. Marga Mulya',
                'username'          => 'adminkel.margamulya',
                'email'             => 'adminkel.margamulya@gmail.com',
                'email_verified_at' => $dateTime[0]->date_time,
                'password'          => Hash::make('password'),
                'remember_token'    => Str::random(10),
                'photo'             => null,
                'role_id'           => 2,
                'is_active'         => true,
            ],

            // Akun Tamu
            [
                'name'              => 'Guest',
                'username'          => 'guest',
                'email'             => 'guest@gmail.com',
                'email_verified_at' => $dateTime[0]->date_time,
                'password'          => Hash::make('password'),
                'remember_token'    => Str::random(10),
                'photo'             => null,
                'role_id'           => 3,
                'is_active'         => true,
            ],
        ];

        User::insert($defaultUsers);
    }
}
