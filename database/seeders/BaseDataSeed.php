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

        DB::table('users')->insert([
            [
                'name' => 'Nandog',
                'nik' => '1234123412341234',
                'email' => 'nandog@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        DB::table('users')->insert([
            [
                'name' => 'admin',
                'nik' => '1111111111111111',
                'email' => 'admin@example.com',
                'role' => 'admin',
                'password' => Hash::make('admin'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        DB::table('users')->insert([
            [
                'name' => 'Amanda Wijaya',
                'nik' => '1234123412340001',
                'email' => 'amanda@example.com',
                'role' => 'doctor',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bima Raharja',
                'nik' => '1234123412340002',
                'email' => 'bima@example.com',
                'role' => 'doctor',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Citra Ayu',
                'nik' => '1234123412340003',
                'email' => 'citra@example.com',
                'role' => 'doctor',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('polyclinics')->insert([
            [
                'name' => 'Klinik Anak',
                'location' => 'Gedung Cokro Aminoto Lt.3',
                'category' => 1,
                'open_time' => '08:00',
                'close_time' => '13:00',
                'capacity' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Klinik Bedah Mulut',
                'location' => 'Gedung Cokro Aminoto Lt.3',
                'category' => 2,
                'open_time' => '07:00',
                'close_time' => '11:00',
                'capacity' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Klinik Dokter Gigi',
                'location' => 'Gedung Cokro Aminoto Lt.4',
                'category' => 3,
                'open_time' => '09:00',
                'close_time' => '12:00',
                'capacity' => 20,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Assume users already exist with matching NIKs
        DB::table('doctors')->insert([
            [
                'nik' => '1234123412340001',
                'name' => 'Dr. Amanda Wijaya',
                'specialization' => 'Pediatric',
                'practice_location' => 'Gedung Cokro Lt.3',
                'photo' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nik' => '1234123412340002',
                'name' => 'Dr. Bima Raharja',
                'specialization' => 'Pediatric',
                'practice_location' => 'Gedung Cokro Lt.3',
                'photo' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nik' => '1234123412340003',
                'name' => 'Dr. Citra Ayu',
                'specialization' => 'Pediatric',
                'practice_location' => 'Gedung Cokro Lt.3',
                'photo' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Optional: Add appointment tickets
        DB::table('appointment_ticket')->insert([
            [
                'queue_number' => 'A01',
                'booking_code' => strtoupper(Str::random(10)),
                'user_id' => 1,
                'doctor_id' => 1,
                'polyclinic_id' => 1,
                'status' => 1,
                'appointment_date' => Carbon::now()->addDays(3)->format('Y-m-d'),
                'appointment_time' => '09:00',
                'payment_method' => 'Umum',
                'consultation_fee' => 225000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
