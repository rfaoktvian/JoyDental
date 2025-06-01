<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Polyclinic;
use App\Models\Doctor;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $doctorProfile = $user->doctor ?? null;

        $polyclinics = Polyclinic::inRandomOrder()->take(3)->get();
        $doctors = Doctor::select('doctors.*')
            ->leftJoin('doctor_reviews', 'doctors.id', '=', 'doctor_reviews.doctor_id')
            ->selectRaw('AVG(doctor_reviews.rating) as avg_rating')
            ->groupBy('doctors.id')
            ->orderByDesc('avg_rating')
            ->take(value: 3)
            ->get();

        return view('dashboard', compact(
            'user',
            'doctorProfile',
            'polyclinics',
            'doctors'
        ));
    }
    public function doctorDashboard()
    {
        $user = auth()->user();
        $doctorProfile = $user->doctor ?? null;

        $doctorsCount = Doctor::count();
        $appointmentsToday = \App\Models\Appointment::whereDate('appointment_date', now())->count();
        $averageRating = \App\Models\DoctorReview::avg('rating') ?? 0;

        $recentDoctors = Doctor::with(['reviews', 'schedules.polyclinic', 'user'])
            ->orderBy('updated_at', 'desc')
            ->take(10)
            ->get();

        return view('doctor.dashboard', compact(
            'user',
            'doctorProfile',
            'doctorsCount',
            'appointmentsToday',
            'averageRating',
            'recentDoctors'
        ));
    }
}