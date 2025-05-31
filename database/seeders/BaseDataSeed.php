<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BaseDataSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $now = Carbon::now();

        $polyclinics = [
            ['name' => 'Klinik Umum', 'location' => 'Gedung Cokro Aminoto Lt.2', 'type' => 1, 'capacity' => 30],
            ['name' => 'Klinik Anak', 'location' => 'Gedung Cokro Aminoto Lt.3', 'type' => 2, 'capacity' => 30],
            ['name' => 'Klinik Gigi', 'location' => 'Gedung Cokro Aminoto Lt.4', 'type' => 3, 'capacity' => 30],
            ['name' => 'Klinik Bedah', 'location' => 'Gedung Cokro Aminoto Lt.5', 'type' => 4, 'capacity' => 30],
            ['name' => 'Klinik Jantung', 'location' => 'Gedung Cokro Aminoto Lt.1', 'type' => 5, 'capacity' => 30],
            ['name' => 'Klinik THT', 'location' => 'Gedung Cokro Aminoto Lt.2', 'type' => 6, 'capacity' => 30],
            ['name' => 'Klinik Mata', 'location' => 'Gedung Cokro Aminoto Lt.3', 'type' => 7, 'capacity' => 30],
            ['name' => 'Klinik Saraf', 'location' => 'Gedung Cokro Aminoto Lt.4', 'type' => 8, 'capacity' => 30],
            ['name' => 'Klinik Kulit & Kelamin', 'location' => 'Gedung Cokro Aminoto Lt.5', 'type' => 9, 'capacity' => 30],
            ['name' => 'Klinik Penyakit Dalam', 'location' => 'Gedung Cokro Aminoto Lt.1', 'type' => 10, 'capacity' => 30],
            ['name' => 'Klinik Gizi', 'location' => 'Gedung Cokro Aminoto Lt.3', 'type' => 11, 'capacity' => 30],
            ['name' => 'Klinik Rehabilitasi', 'location' => 'Gedung Cokro Aminoto Lt.4', 'type' => 12, 'capacity' => 30],
            ['name' => 'Klinik Psikologi', 'location' => 'Gedung Cokro Aminoto Lt.5', 'type' => 13, 'capacity' => 30],
            ['name' => 'Klinik Gizi Klinik', 'location' => 'Gedung Cokro Aminoto Lt.1', 'type' => 14, 'capacity' => 30],
            ['name' => 'Klinik Urologi', 'location' => 'Gedung Cokro Aminoto Lt.2', 'type' => 15, 'capacity' => 30],
            ['name' => 'Klinik Imunologi', 'location' => 'Gedung Cokro Aminoto Lt.5', 'type' => 16, 'capacity' => 30],
            ['name' => 'Klinik Infeksi', 'location' => 'Gedung Cokro Aminoto Lt.5', 'type' => 17, 'capacity' => 30],
            ['name' => 'Klinik Alergi', 'location' => 'Gedung Cokro Aminoto Lt.2', 'type' => 18, 'capacity' => 30],
            ['name' => 'Klinik Tumbuh Kembang', 'location' => 'Gedung Cokro Aminoto Lt.2', 'type' => 19, 'capacity' => 30],
            ['name' => 'Klinik Gawat Darurat', 'location' => 'Gedung Cokro Aminoto Lt.1', 'type' => 20, 'capacity' => 30],
            ['name' => 'Klinik Radiologi', 'location' => 'Gedung Cokro Aminoto Lt.3', 'type' => 21, 'capacity' => 30],
            ['name' => 'Klinik Anestesi', 'location' => 'Gedung Cokro Aminoto Lt.4', 'type' => 22, 'capacity' => 30],
            ['name' => 'Klinik Laboratorium', 'location' => 'Gedung Cokro Aminoto Lt.5', 'type' => 23, 'capacity' => 30],
            ['name' => 'Klinik Nefrologi', 'location' => 'Gedung Cokro Aminoto Lt.1', 'type' => 24, 'capacity' => 30],
            ['name' => 'Klinik Hematologi', 'location' => 'Gedung Cokro Aminoto Lt.2', 'type' => 25, 'capacity' => 30],
            ['name' => 'Klinik Psikiatri', 'location' => 'Gedung Cokro Aminoto Lt.3', 'type' => 26, 'capacity' => 30],
            ['name' => 'Klinik Gastroenterologi', 'location' => 'Gedung Cokro Aminoto Lt.4', 'type' => 27, 'capacity' => 30],
            ['name' => 'Klinik Bedah Saraf', 'location' => 'Gedung Cokro Aminoto Lt.5', 'type' => 28, 'capacity' => 30],
            ['name' => 'Klinik Reproduksi', 'location' => 'Gedung Cokro Aminoto Lt.1', 'type' => 29, 'capacity' => 30],
            ['name' => 'Klinik Ginekologi', 'location' => 'Gedung Cokro Aminoto Lt.2', 'type' => 30, 'capacity' => 30],
        ];
        foreach ($polyclinics as &$clinic) {
            $clinic['created_at'] = $now;
            $clinic['updated_at'] = $now;
        }

        DB::table('polyclinics')->insert($polyclinics);

        DB::table('users')->insert([
            [
                'name' => 'admin',
                'nik' => '1111111111111111',
                'email' => 'admin@example.com',
                'role' => 'admin',
                'password' => Hash::make('admin'),
                'email_verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ]);

        DB::table('users')->insert([
            [
                'name' => 'Amanda Wijaya',
                'nik' => '1234123412340001',
                'email' => 'amanda@example.com',
                'role' => 'doctor',
                'password' => Hash::make('password'),
                'email_verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Bima Raharja',
                'nik' => '1234123412340002',
                'email' => 'bima@example.com',
                'role' => 'doctor',
                'password' => Hash::make('password'),
                'email_verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Citra Ayu',
                'nik' => '1234123412340003',
                'email' => 'citra@example.com',
                'role' => 'doctor',
                'password' => Hash::make('password'),
                'email_verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        $doctors = [
            [
                'nik' => '1234123412340001',
                'name' => 'dr. Amanda Wijaya',
                'specialization' => 'Dokter Anak',
                'photo' => 'amanda.png',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nik' => '1234123412340002',
                'name' => 'dr. Bima Raharja',
                'specialization' => 'Bedah Mulut',
                'photo' => 'bima.png',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nik' => '1234123412340003',
                'name' => 'drg. Citra Ayu',
                'specialization' => 'Dokter Gigi',
                'photo' => 'citra.png',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('doctors')->insert($doctors);

        $doctorSchedules = [
            [
                'doctor_id' => 1, // Amanda Wijaya
                'day' => 'Senin',
                'time_from' => '09:00',
                'time_to' => '14:00',
                'max_capacity' => 10,
                'created_at' => $now,
                'updated_at' => $now,
                'polyclinic_id' => 2, // Klinik Anak
            ],
            [
                'doctor_id' => 2, // Bima Raharja
                'day' => 'Selasa',
                'time_from' => '10:00',
                'time_to' => '15:00',
                'max_capacity' => 12,
                'created_at' => $now,
                'updated_at' => $now,
                'polyclinic_id' => 4, // Klinik Bedah
            ],
            [
                'doctor_id' => 3, // Citra Ayu
                'day' => 'Rabu',
                'time_from' => '08:00',
                'time_to' => '12:00',
                'max_capacity' => 8,
                'created_at' => $now,
                'updated_at' => $now,
                'polyclinic_id' => 3, // Klinik Gigi
            ],
        ];

        DB::table('doctor_schedules')->insert($doctorSchedules);

        $reviews = [
            [
                'doctor_id' => 1,
                'user_id' => 1,
                'rating' => 5,
                'comment' => 'Dokter sangat ramah dan informatif. Terima kasih!',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'doctor_id' => 1,
                'user_id' => 2,
                'rating' => 4,
                'comment' => 'Pelayanan cepat dan jelas, tapi ruang tunggu agak penuh.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'doctor_id' => 2,
                'user_id' => 3,
                'rating' => 5,
                'comment' => 'Sangat puas dengan hasil konsultasi. Rekomendasi!',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'doctor_id' => 3,
                'user_id' => 3,
                'rating' => 3,
                'comment' => 'Dokternya oke, tapi agak terburu-buru menjelaskan.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('doctor_reviews')->insert($reviews);


        for ($i = 1; $i <= 30; $i++) {
            DB::table('appointments')->insert([
                'queue_number' => 'A' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'booking_code' => Str::random(10),
                'user_id' => 1,
                'doctor_id' => 1,
                'doctor_schedule_id' => 1, // Jadwal dokter Amanda
                'status' => 1,
                'appointment_date' => Carbon::now()->addDays(1),
                'appointment_time' => '10:00',
                'payment_method' => 'Cash',
                'consultation_fee' => '25000',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        for ($i = 1; $i <= 20; $i++) {
            $name = Str::random(10);
            DB::table('users')->insert([
                'name' => $name,
                'nik' => str_pad(mt_rand(0, 9999999999999999), 16, '0', STR_PAD_LEFT),
                'email' => strtolower($name) . '@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
