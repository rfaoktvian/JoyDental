<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Testimonial::insert([
            [
                'name' => 'Rina',
                'role' => '34 tahun – Ibu Rumah Tangga',
                'message' => 'Pelayanannya cepat, dokter ramah, dan sistemnya sangat membantu!',
                'avatar_path' => 'images/rina.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Budi',
                'role' => '40 tahun – Karyawan Swasta',
                'message' => 'Saya bisa booking dokter dari rumah tanpa antri lama. Sangat efisien!',
                'avatar_path' => 'images/budi.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sari',
                'role' => '28 tahun – Freelancer',
                'message' => 'Platform ini membantu saya mendapatkan dokter yang tepat dengan cepat.',
                'avatar_path' => 'images/sari.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dewi',
                'role' => '25 tahun – Mahasiswa',
                'message' => 'Sangat terbantu dengan fitur antrian online, tidak perlu datang lebih awal.',
                'avatar_path' => 'images/dewi.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Andi',
                'role' => '31 tahun – Pegawai Negeri',
                'message' => 'Saya suka desain aplikasinya, simpel dan mudah digunakan.',
                'avatar_path' => 'images/andi.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Lina',
                'role' => '38 tahun – Ibu 2 Anak',
                'message' => 'Dokternya profesional dan staffnya sangat membantu. Sangat recommended!',
                'avatar_path' => 'images/lina.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
