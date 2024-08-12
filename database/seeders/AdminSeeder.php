<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultUserAdmins = [
            // Super Admin
            [
                'user_id'           => 1,
                'phone_number'      => fake()->unique()->numerify('08##########'),
                'province_id'       => null,
                'regency_id'        => null,
                'district_id'       => null,
                'village_id'        => null,
            ],

            // Admin Provinsi SumSel
            [
                'user_id'           => 2,
                'phone_number'      => fake()->unique()->numerify('08##########'),
                'province_id'       => 16,
                'regency_id'        => null,
                'district_id'       => null,
                'village_id'        => null,
            ],

            // Admin Kota Sumsel -> Palembang
            [
                'user_id'           => 3,
                'phone_number'      => fake()->unique()->numerify('08##########'),
                'province_id'       => 16,
                'regency_id'        => 1671,
                'district_id'       => null,
                'village_id'        => null,
            ],

            // Admin Kecamatan Palembang -> Jakabaring
            [
                'user_id'           => 4,
                'phone_number'      => fake()->unique()->numerify('08##########'),
                'province_id'       => 16,
                'regency_id'        => 1671,
                'district_id'       => 1671022,
                'village_id'        => null,
            ],

            // Admin Kelurahan Palembang -> Jakabaring -> Silaberanti
            [
                'user_id'           => 5,
                'phone_number'      => fake()->unique()->numerify('08##########'),
                'province_id'       => 16,
                'regency_id'        => 1671,
                'district_id'       => 1671022,
                'village_id'        => 1671022004,
            ],

            // Admin Kabupaten Ogan Komering Ulu
            [
                'user_id'           => 6,
                'phone_number'      => fake()->unique()->numerify('08##########'),
                'province_id'       => 16,
                'regency_id'        => 1601,
                'district_id'       => null,
                'village_id'        => null,
            ],

            // Admin Kecamatan OKU -> Sinar Peninjauan
            [
                'user_id'           => 7,
                'phone_number'      => fake()->unique()->numerify('08##########'),
                'province_id'       => 16,
                'regency_id'        => 1601,
                'district_id'       => 1601092,
                'village_id'        => null,
            ],

            // Admin Kelurahan OKU -> Sinar Peninjauan -> Marga Mulya
            [
                'user_id'           => 8,
                'phone_number'      => fake()->unique()->numerify('08##########'),
                'province_id'       => 16,
                'regency_id'        => 1601,
                'district_id'       => 1601092,
                'village_id'        => 1601092005,
            ],
        ];

        Admin::insert($defaultUserAdmins);
    }
}
