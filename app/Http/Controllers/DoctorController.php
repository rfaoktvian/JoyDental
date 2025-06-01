<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Appointment;
use Carbon\Carbon;

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

    public function laporan()
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

        return view('doctor.laporan', compact(
            'user',
            'doctorProfile',
            'activeQueue',
            'upcomingAppointments',
            'recentConsultation',
            'todayAppointments'
        ));
    }
    public function riwayat()
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

        return view('doctor.riwayat', compact(
            'user',
            'doctorProfile',
            'activeQueue',
            'upcomingAppointments',
            'recentConsultation',
            'todayAppointments'
        ));
    }
}
