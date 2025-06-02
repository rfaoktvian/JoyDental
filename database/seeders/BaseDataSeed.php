<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;

class BaseDataSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        $faker = Faker::create();

        // 1️⃣ Seed Polyclinics
        $this->seedPolyclinics($now);

        // 2️⃣ Seed Admin User
        $this->seedAdminUser($now);

        // 3️⃣ Seed Doctors (Users + Doctors)
        $doctorIds = $this->seedDoctors($faker, $now);

        // 4️⃣ Seed Doctor Schedules
        $this->seedDoctorSchedules($faker, $doctorIds, $now);

        // 5️⃣ Seed Additional Users
        $userIds = $this->seedUsers($faker, $now);

        // 6️⃣ Seed Appointments
        $this->seedAppointments($faker, $doctorIds, $userIds, $now);

        // 7️⃣ Seed Doctor Reviews
        $this->seedDoctorReviews($faker, $doctorIds, $userIds, $now);
    }

    private function seedPolyclinics($now)
    {
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
            $clinic['capacity'] = 30;
            $clinic['created_at'] = $now;
            $clinic['updated_at'] = $now;
        }

        DB::table('polyclinics')->insert($polyclinics);
    }

    private function seedAdminUser($now)
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'nik' => '1111111111111111',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => Hash::make('admin'),
            'email_verified_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('users')->insert([
            'name' => 'dokter',
            'nik' => '2222222222222222',
            'email' => 'dokter@example.com',
            'role' => 'doctor',
            'password' => Hash::make('dokter'),
            'email_verified_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    private function seedDoctors($faker, $now)
    {
        $doctorIds = [];

        for ($i = 1; $i <= 10; $i++) {
            $nik = str_pad(mt_rand(0, 9999999999999999), 16, '0', STR_PAD_LEFT);
            $name = $faker->name;
            $email = strtolower(Str::slug($name)) . '@example.com';

            // Insert user first
            DB::table('users')->insert([
                'name' => $name,
                'nik' => $nik,
                'email' => $email,
                'password' => Hash::make('password'),
                'role' => 'doctor',
                'email_verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            // Insert doctor
            $doctorId = DB::table('doctors')->insertGetId([
                'nik' => $nik,
                'name' => $name,
                'description' => Str::limit($faker->paragraph, 10),
                'specialization' => $faker->word,
                'photo' => null,
                'registered' => $faker->date(),
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $doctorIds[] = $doctorId;
        }

        return $doctorIds;
    }

    private function seedDoctorSchedules($faker, $doctorIds, $now)
    {
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        foreach ($doctorIds as $doctorId) {
            foreach ($days as $day) {
                DB::table('doctor_schedules')->insert([
                    'doctor_id' => $doctorId,
                    'day' => $day,
                    'time_from' => $faker->time('H:i'),
                    'time_to' => $faker->time('H:i'),
                    'max_capacity' => $faker->numberBetween(5, 15),
                    'polyclinic_id' => $faker->numberBetween(1, 30),
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }

    private function seedUsers($faker, $now)
    {
        $userIds = [];

        for ($i = 1; $i <= 20; $i++) {
            $name = $faker->name;
            $nik = str_pad(mt_rand(0, 9999999999999999), 16, '0', STR_PAD_LEFT);

            $userId = DB::table('users')->insertGetId([
                'name' => $name,
                'nik' => $nik,
                'email' => strtolower(Str::slug($name, '.')) . '@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'email_verified_at' => $now,
                'address' => $faker->address,
                'phone' => $faker->phoneNumber,
                'gender' => $faker->randomElement(['man', 'woman']),
                'birth_date' => $faker->date(),
                'occupation' => $faker->jobTitle,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $userIds[] = $userId;
        }

        return $userIds;
    }

    private function seedAppointments($faker, $doctorIds, $userIds, $now)
    {
        $scheduleIds = DB::table('doctor_schedules')->pluck('id');

        for ($i = 1; $i <= 50; $i++) {
            $status = $faker->randomElement([1, 2, 3]);

            DB::table('appointments')->insert([
                'queue_number' => strtoupper(Str::random(5)),
                'booking_code' => strtoupper(Str::random(8)),
                'user_id' => $faker->randomElement($userIds),
                'doctor_id' => $faker->randomElement($doctorIds),
                'doctor_schedule_id' => $faker->randomElement($scheduleIds),
                'status' => $status,
                'appointment_date' => $faker->date(),
                'appointment_time' => $faker->time('H:i'),
                'payment_method' => $faker->randomElement(['Cash', 'Insurance', 'Transfer']),
                'consultation_fee' => $faker->numberBetween(50000, 200000),
                'visit_date' => $status === 2 ? $faker->date() : null,
                'visit_time' => $status === 2 ? $faker->time('H:i') : null,
                'chief_complaint' => $faker->sentence,
                'diagnosis' => $status === 2 ? $faker->sentence : null,
                'treatment' => $faker->sentence,
                'prescription' => $faker->sentence,
                'doctor_notes' => $faker->sentence,
                'follow_up_date' => $faker->optional()->date(),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    private function seedDoctorReviews($faker, $doctorIds, $userIds, $now)
    {
        foreach ($doctorIds as $doctorId) {
            $reviewCount = $faker->numberBetween(3, 10);

            for ($i = 0; $i < $reviewCount; $i++) {
                $userId = $faker->randomElement($userIds);

                DB::table('doctor_reviews')->updateOrInsert(
                    [
                        'doctor_id' => $doctorId,
                        'user_id' => $userId,
                    ],
                    [
                        'rating' => $faker->numberBetween(1, 5),
                        'comment' => $faker->sentence,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );
            }
        }
    }
}
