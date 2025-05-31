<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with('schedules.polyclinic', 'reviews')->get();
        return view('dokter', compact('doctors'));
    }

    public function getScheduleForm($doctorId)
    {
        $doctor = Doctor::with(['schedules.polyclinic'])->findOrFail($doctorId);

        $dayOrder = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $doctor->schedules = $doctor->schedules->sortBy(function ($schedule) use ($dayOrder) {
            return array_search($schedule->day, $dayOrder);
        });

        return view('partials.doctor-schedules-modal', compact('doctor'));
    }

    public function getReviews($doctorId)
    {
        $doctor = Doctor::with('reviews')->findOrFail($doctorId);
        return view('partials.doctor-reviews-modal', compact('doctor'));
    }
}
