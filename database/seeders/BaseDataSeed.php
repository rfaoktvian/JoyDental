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

        //  Seed Polyclinics
        $this->seedPolyclinics($now);

        // Seed Admin User
        $this->seedAdminUser($now);

        //  Seed Doctors (Users + Doctors)
        $doctorIds = $this->seedDoctors($faker, $now);

        //  Seed Doctor Schedules
        $this->seedDoctorSchedules($faker, $doctorIds, $now);

        //  Seed Additional Users
        $userIds = $this->seedUsers($faker, $now);

        //  Seed Appointments
        $this->seedAppointments($faker, $doctorIds, $userIds, $now);

        //  Seed Doctor Reviews
        $this->seedDoctorReviews($faker, $doctorIds, $userIds, $now);
    }

    private function seedPolyclinics($now)
    {
        $serviceSpecializations = [
            'Scaling' => 'General Dentistry',
            'Tambal Gigi' => 'Conservative Dentistry',
            'Cabut Gigi' => 'Oral Surgery',
            'Behel' => 'Orthodontics',
            'Bleaching' => 'Esthetic Dentistry',
            'Veneer' => 'Esthetic Dentistry',
            'Perawatan Saluran Akar' => 'Endodontics',
            'Gigi Tiruan' => 'Prosthodontics',
            'Tambal Estetik' => 'Esthetic Dentistry',
            'Konsultasi Gigi' => 'General Dentistry',
        ];

        $locations = [
            'Klinik Gigi Purwokerto',
            'Klinik Gigi Yogyakarta',
            'Klinik Gigi Semarang',
        ];

        $data = [];

        foreach ($serviceSpecializations as $service => $specialization) {
            foreach ($locations as $location) {
                $data[] = [
                    'name' => $service,
                    'location' => $location,
                    'specialization' => $specialization,
                    'capacity' => 30,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        DB::table('polyclinics')->insert($data);
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

        // Ambil spesialisasi dari polyclinics
        $specializations = DB::table('polyclinics')
            ->pluck('specialization')
            ->unique()
            ->values()
            ->toArray();

        for ($i = 1; $i <= 10; $i++) {
            $nik = str_pad(mt_rand(0, 9999999999999999), 16, '0', STR_PAD_LEFT);
            $name = $faker->name;
            $email = strtolower(Str::slug($name)) . '@example.com';

            // Insert user
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
                'description' => Str::limit($faker->paragraph, 120),
                'specialization' => $faker->randomElement($specializations),
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
        $polyclinicIds = DB::table('polyclinics')->pluck('id')->toArray();

        foreach ($doctorIds as $doctorId) {
            foreach ($days as $day) {
                DB::table('doctor_schedules')->insert([
                    'doctor_id' => $doctorId,
                    'day' => $day,
                    'time_from' => $faker->time('H:i'),
                    'time_to' => $faker->time('H:i'),
                    'max_capacity' => $faker->numberBetween(5, 15),
                    'polyclinic_id' => $faker->randomElement($polyclinicIds),
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
                        'rating' => $faker->numberBetween(4, 5),
                        'comment' => $faker->sentence,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );
            }
        }
    }
}
