<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Polyclinic;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\DoctorReview;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard()
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

        $doctorReviews = DoctorReview::with(['doctor', 'user'])
            ->orderByDesc('rating')
            ->latest()
            ->take(value: 5)
            ->get();

        Appointment::where('status', 1)
            ->where(function ($query) {
                $query->where('appointment_date', '<', now()->toDateString())
                    ->orWhere(function ($q) {
                        $q->whereDate('appointment_date', now()->toDateString())
                            ->whereRaw('appointment_time < TIME(NOW())');
                    });
            })
            ->update(['status' => 3]);

        $base = Appointment::with(['clinic']);

        $listQuery = clone $base;

        $appointments = $listQuery->where('status', 1)
            ->latest('appointment_date')
            ->take(value: 3)
            ->get();

        return view('dashboard', compact(
            'user',
            'doctorProfile',
            'polyclinics',
            'doctors',
            'appointments',
            'doctorReviews'
        ));
    }

    public function doctorDashboard()
    {
        $user = auth()->user();
        $doctorProfile = $user->doctor;

        $today = now()->toDateString();
        $nowTime = Carbon::now()->format('H:i:s');

        Appointment::where('status', 1)
            ->where(function ($query) {
                $query->where('appointment_date', '<', now()->toDateString())
                    ->orWhere(function ($q) {
                        $q->whereDate('appointment_date', now()->toDateString())
                            ->whereRaw('appointment_time < TIME(NOW())');
                    });
            })
            ->update(['status' => 3]);

        $baseQuery = Appointment::query();
        if ($user->role === 'doctor') {
            $baseQuery->where('doctor_id', optional($doctorProfile)->id);
        }

        $activeQueue = (clone $baseQuery)
            ->where('status', 1)
            ->where('appointment_date', $today)
            ->whereRaw("STR_TO_DATE(appointment_time, '%H:%i:%s') >= STR_TO_DATE(?, '%H:%i:%s')", [$nowTime])
            ->count();

        $appointmentsToday = (clone $baseQuery)
            ->whereDate('appointment_date', $today)
            ->count();

        $todayAppointments = (clone $baseQuery)
            ->with(['patient', 'clinic'])
            ->whereDate('appointment_date', $today)
            ->where('status', 1)
            ->orderBy('appointment_time')
            ->paginate(3);

        $upcomingAppointments = (clone $baseQuery)
            ->whereDate('appointment_date', '>', $today)
            ->count();

        $recentConsultation = (clone $baseQuery)
            ->where('status', 2)
            ->with('user')
            ->latest('appointment_date')
            ->first();

        return view('doctor.dashboard', compact(
            'user',
            'doctorProfile',
            'activeQueue',
            'appointmentsToday',
            'upcomingAppointments',
            'recentConsultation',
            'todayAppointments'
        ));
    }

}