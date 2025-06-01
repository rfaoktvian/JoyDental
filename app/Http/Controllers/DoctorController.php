<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Polyclinic;
use App\Models\Appointment;
use App\Models\DoctorReview;
use Carbon\Carbon;
use DB;

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

    public function profileDoctor(Request $request)
    {
        $user = auth()->user();
        $doctorProfile = $user->doctor;

        // Fetch doctor with schedules
        if ($doctorProfile) {
            $doctorProfile->load(['schedules.polyclinic']); // eager load schedules and polyclinic
        }

        return view('doctor.profile', compact(var_name: 'doctorProfile'));
    }

    public function laporan(Request $request)
    {
        $period = $request->get('period', 'daily');
        $selectedDate = $request->get('date', now()->toDateString());

        $totalDoctors = Doctor::count();
        $totalPatients = User::where('role', 'user')->count();
        $totalPolyclinics = Polyclinic::count();

        $baseA = Appointment::with(['user', 'doctor', 'clinic']);

        $dateLabels = [];
        $countPerDay = [];
        $weeklyLabel = null;
        $monthLabel = null;
        $yearLabel = null;

        switch ($period) {
            case 'weekly':
                $startOfWeek = now()->startOfWeek();
                $endOfWeek = now()->endOfWeek();
                $weeklyLabel = 'Minggu ke-' . now()->isoWeek() . ', ' . now()->year;

                for ($i = 0; $i < 7; $i++) {
                    $dt = $startOfWeek->copy()->addDays($i);
                    $dateLabels[] = $dt->translatedFormat('D');
                    $countPerDay[] = (clone $baseA)
                        ->whereDate('appointment_date', $dt->toDateString())
                        ->count();
                }
                break;

            case 'monthly':
                $startOfMonth = now()->startOfMonth();
                $daysInMonth = now()->daysInMonth;
                $monthLabel = now()->translatedFormat('F Y');

                for ($i = 0; $i < $daysInMonth; $i++) {
                    $dt = $startOfMonth->copy()->addDays($i);
                    $dateLabels[] = $dt->format('d');
                    $countPerDay[] = (clone $baseA)
                        ->whereDate('appointment_date', $dt->toDateString())
                        ->count();
                }
                break;

            case 'yearly':
                $year = now()->year;
                $yearLabel = $year;

                for ($m = 1; $m <= 12; $m++) {
                    $dt = Carbon::createFromDate($year, $m, 1);
                    $dateLabels[] = $dt->translatedFormat('M');
                    $countPerDay[] = (clone $baseA)
                        ->whereMonth('appointment_date', $m)
                        ->whereYear('appointment_date', $year)
                        ->count();
                }
                break;

            case 'daily':
            default:
                $dt = Carbon::parse($selectedDate);
                $dateLabels[] = $dt->translatedFormat('d M Y');
                $countPerDay[] = (clone $baseA)
                    ->whereDate('appointment_date', $selectedDate)
                    ->count();
                break;
        }

        switch ($period) {
            case 'weekly':
                $appointmentsCount = (clone $baseA)
                    ->whereBetween('appointment_date', [
                        $startOfWeek->toDateString(),
                        $endOfWeek->toDateString()
                    ])
                    ->count();

                $revenue = (clone $baseA)
                    ->whereBetween('appointment_date', [
                        $startOfWeek->toDateString(),
                        $endOfWeek->toDateString()
                    ])
                    ->sum('consultation_fee');
                break;

            case 'monthly':
                $appointmentsCount = (clone $baseA)
                    ->whereMonth('appointment_date', now()->month)
                    ->whereYear('appointment_date', now()->year)
                    ->count();

                $revenue = (clone $baseA)
                    ->whereMonth('appointment_date', now()->month)
                    ->whereYear('appointment_date', now()->year)
                    ->sum('consultation_fee');
                break;

            case 'yearly':
                $appointmentsCount = (clone $baseA)
                    ->whereYear('appointment_date', now()->year)
                    ->count();

                $revenue = (clone $baseA)
                    ->whereYear('appointment_date', now()->year)
                    ->sum('consultation_fee');
                break;

            case 'daily':
            default:
                $appointmentsCount = (clone $baseA)
                    ->whereDate('appointment_date', $selectedDate)
                    ->count();

                $revenue = (clone $baseA)
                    ->whereDate('appointment_date', $selectedDate)
                    ->sum('consultation_fee');
                break;
        }

        $formattedRevenue = 'Rp ' . number_format($revenue, 0, ',', '.');

        $averageRatingAllDoctors = DoctorReview::avg('rating') ?: 0;
        $averageRatingAllDoctors = number_format($averageRatingAllDoctors, 1);

        switch ($period) {
            case 'weekly':
                $detailedAppointments = (clone $baseA)
                    ->whereBetween('appointment_date', [
                        $startOfWeek->toDateString(),
                        $endOfWeek->toDateString()
                    ])
                    ->orderBy('appointment_date')
                    ->orderBy('appointment_time')
                    ->paginate(10);
                break;

            case 'monthly':
                $detailedAppointments = (clone $baseA)
                    ->whereMonth('appointment_date', now()->month)
                    ->whereYear('appointment_date', now()->year)
                    ->orderBy('appointment_date')
                    ->orderBy('appointment_time')
                    ->paginate(10);
                break;

            case 'yearly':
                $detailedAppointments = (clone $baseA)
                    ->whereYear('appointment_date', now()->year)
                    ->orderBy('appointment_date')
                    ->orderBy('appointment_time')
                    ->paginate(10);
                break;

            case 'daily':
            default:
                $detailedAppointments = (clone $baseA)
                    ->whereDate('appointment_date', $selectedDate)
                    ->orderBy('appointment_time')
                    ->paginate(10);
                break;
        }

        return view('doctor.laporan', [
            'period' => $period,
            'selectedDate' => $selectedDate,
            'weeklyLabel' => $weeklyLabel,
            'monthLabel' => $monthLabel,
            'yearLabel' => $yearLabel,
            'dateLabels' => $dateLabels,
            'countPerDay' => $countPerDay,
            'totalDoctors' => $totalDoctors,
            'totalPatients' => $totalPatients,
            'totalPolyclinics' => $totalPolyclinics,
            'appointmentsCount' => $appointmentsCount,
            'formattedRevenue' => $formattedRevenue,
            'averageRatingAllDoctors' => $averageRatingAllDoctors,
            // Tabel detail janji temu
            'todayAppointments' => $detailedAppointments,
        ]);
    }

    public function riwayat(Request $request)
    {
        $period = $request->get('period', 'daily');
        $selectedDate = $request->get('date', now()->toDateString());

        $totalDoctors = Doctor::count();
        $totalPatients = User::where('role', 'user')->count();
        $totalPolyclinics = Polyclinic::count();

        $baseA = Appointment::with(['user', 'doctor', 'clinic']);

        $dateLabels = [];
        $countPerDay = [];
        $weeklyLabel = null;
        $monthLabel = null;
        $yearLabel = null;

        switch ($period) {
            case 'weekly':
                $startOfWeek = now()->startOfWeek();
                $endOfWeek = now()->endOfWeek();
                $weeklyLabel = 'Minggu ke-' . now()->isoWeek() . ', ' . now()->year;

                for ($i = 0; $i < 7; $i++) {
                    $dt = $startOfWeek->copy()->addDays($i);
                    $dateLabels[] = $dt->translatedFormat('D');
                    $countPerDay[] = (clone $baseA)
                        ->whereDate('appointment_date', $dt->toDateString())
                        ->count();
                }
                break;

            case 'monthly':
                $startOfMonth = now()->startOfMonth();
                $daysInMonth = now()->daysInMonth;
                $monthLabel = now()->translatedFormat('F Y');

                for ($i = 0; $i < $daysInMonth; $i++) {
                    $dt = $startOfMonth->copy()->addDays($i);
                    $dateLabels[] = $dt->format('d');
                    $countPerDay[] = (clone $baseA)
                        ->whereDate('appointment_date', $dt->toDateString())
                        ->count();
                }
                break;

            case 'yearly':
                $year = now()->year;
                $yearLabel = $year;

                for ($m = 1; $m <= 12; $m++) {
                    $dt = Carbon::createFromDate($year, $m, 1);
                    $dateLabels[] = $dt->translatedFormat('M');
                    $countPerDay[] = (clone $baseA)
                        ->whereMonth('appointment_date', $m)
                        ->whereYear('appointment_date', $year)
                        ->count();
                }
                break;

            case 'daily':
            default:
                $dt = Carbon::parse($selectedDate);
                $dateLabels[] = $dt->translatedFormat('d M Y');
                $countPerDay[] = (clone $baseA)
                    ->whereDate('appointment_date', $selectedDate)
                    ->count();
                break;
        }

        switch ($period) {
            case 'weekly':
                $appointmentsCount = (clone $baseA)
                    ->whereBetween('appointment_date', [
                        $startOfWeek->toDateString(),
                        $endOfWeek->toDateString()
                    ])
                    ->count();

                $revenue = (clone $baseA)
                    ->whereBetween('appointment_date', [
                        $startOfWeek->toDateString(),
                        $endOfWeek->toDateString()
                    ])
                    ->sum('consultation_fee');
                break;

            case 'monthly':
                $appointmentsCount = (clone $baseA)
                    ->whereMonth('appointment_date', now()->month)
                    ->whereYear('appointment_date', now()->year)
                    ->count();

                $revenue = (clone $baseA)
                    ->whereMonth('appointment_date', now()->month)
                    ->whereYear('appointment_date', now()->year)
                    ->sum('consultation_fee');
                break;

            case 'yearly':
                $appointmentsCount = (clone $baseA)
                    ->whereYear('appointment_date', now()->year)
                    ->count();

                $revenue = (clone $baseA)
                    ->whereYear('appointment_date', now()->year)
                    ->sum('consultation_fee');
                break;

            case 'daily':
            default:
                $appointmentsCount = (clone $baseA)
                    ->whereDate('appointment_date', $selectedDate)
                    ->count();

                $revenue = (clone $baseA)
                    ->whereDate('appointment_date', $selectedDate)
                    ->sum('consultation_fee');
                break;
        }

        $formattedRevenue = 'Rp ' . number_format($revenue, 0, ',', '.');

        $averageRatingAllDoctors = DoctorReview::avg('rating') ?: 0;
        $averageRatingAllDoctors = number_format($averageRatingAllDoctors, 1);

        switch ($period) {
            case 'weekly':
                $detailedAppointments = (clone $baseA)
                    ->whereBetween('appointment_date', [
                        $startOfWeek->toDateString(),
                        $endOfWeek->toDateString()
                    ])
                    ->orderBy('appointment_date')
                    ->orderBy('appointment_time')
                    ->paginate(10);
                break;

            case 'monthly':
                $detailedAppointments = (clone $baseA)
                    ->whereMonth('appointment_date', now()->month)
                    ->whereYear('appointment_date', now()->year)
                    ->orderBy('appointment_date')
                    ->orderBy('appointment_time')
                    ->paginate(10);
                break;

            case 'yearly':
                $detailedAppointments = (clone $baseA)
                    ->whereYear('appointment_date', now()->year)
                    ->orderBy('appointment_date')
                    ->orderBy('appointment_time')
                    ->paginate(10);
                break;

            case 'daily':
            default:
                $detailedAppointments = (clone $baseA)
                    ->whereDate('appointment_date', $selectedDate)
                    ->orderBy('appointment_time')
                    ->paginate(10);
                break;
        }

        return view('doctor.riwayat', [
            'period' => $period,
            'selectedDate' => $selectedDate,
            'weeklyLabel' => $weeklyLabel,
            'monthLabel' => $monthLabel,
            'yearLabel' => $yearLabel,
            'dateLabels' => $dateLabels,
            'countPerDay' => $countPerDay,
            'totalDoctors' => $totalDoctors,
            'totalPatients' => $totalPatients,
            'totalPolyclinics' => $totalPolyclinics,
            'appointmentsCount' => $appointmentsCount,
            'formattedRevenue' => $formattedRevenue,
            'averageRatingAllDoctors' => $averageRatingAllDoctors,
            // Tabel detail janji temu
            'todayAppointments' => $detailedAppointments,
        ]);
    }
}
