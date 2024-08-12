<?php

namespace Database\Factories;

use App\Models\FamilyHead;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FamilyActivity>
 */
class FamilyActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randFamilyHeadId = array_rand(FamilyHead::query()->pluck('id')->toArray());

        $up2kActivities = [
            'Usaha Warung', 'Usaha Toko', 'Usaha Kuliner', 'Usaha Online (E-commerce)',
            'Jasa kebersihan', 'Jual Tanaman Hias', 'Katering', 'Menjual Kerajinan Tangan',
            'Menjual Kue,Roti dan Minuman', 'Jasa Konsultasi atau Penasihat', 'Jasa Instruktur Kebugaran',
            'Jasa Desain Grafis atau Web', 'Jasa Sewa Penginapan', 'Jasa Pemeliharaan Kendaraan',
        ];

        $envHealthActivities = [
            'Kerja bakti atau gotong royong', 'Membuat tempat sampah', 'Membuang sampah pada tempatnya',
            'Menyelenggarakan kegiatan penanaman pohon dan tumbuhan', 'Membuat pupuk dari sampah organik',
            'Tidak sembarang membakar sampah',
        ];

        return [
            'family_head_id'        => $randFamilyHeadId,
            'up2k_activity'         => fake()->randomElement($up2kActivities),
            'env_health_activity'   => fake()->randomElement($envHealthActivities),
        ];
    }
}
