<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Enums\AppointmentStatus;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function tiketAntrian()
    {
        $user = Auth::user();
        $currentTab = request('tab', 'all');
        $search = request('q');
        $clinic = request('clinic');

        if ($user->role === 'admin') {
            $base = Appointment::with(['patient', 'clinic', 'doctor']);
        } elseif ($user->role === 'doctor') {
            $base = Appointment::with(['patient', 'clinic'])
                ->where('doctor_id', $user->id);
        } else {
            $base = Appointment::with(['clinic'])
                ->where('user_id', $user->id);
        }

        if ($search) {
            $base->whereHas('patient', fn($q) =>
                $q->where('name', 'like', "%{$search}%"));
        }
        if ($clinic) {
            $base->whereHas('clinic', fn($q) =>
                $q->where('name', $clinic));
        }

        $statusCount = (clone $base)
            ->reorder()
            ->selectRaw('status, COUNT(*) total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $listQuery = clone $base;
        if ($currentTab !== 'all') {
            $listQuery->where('status', AppointmentStatus::fromLabel($currentTab));
        }

        $appointments = $listQuery->latest('appointment_date')
            ->paginate(12)
            ->withQueryString();

        return view('doctor.antrian', compact(
            'appointments',
            'statusCount',
            'currentTab',
            'search',
            'clinic'
        ));
    }


    public function antrianPasien()
    {
        $user = Auth::user();
        $currentTab = request('tab', 'all');
        $search = request('q');
        $clinic = request('clinic');

        if ($user->role === 'admin') {
            $base = Appointment::with(['patient', 'clinic', 'doctor']);
        } elseif ($user->role === 'doctor') {
            $base = Appointment::with(['patient', 'clinic'])
                ->where('doctor_id', $user->id);
        }

        if ($search) {
            $base->whereHas('patient', fn($q) =>
                $q->where('name', 'like', "%{$search}%"));
        }
        if ($clinic) {
            $base->whereHas('clinic', fn($q) =>
                $q->where('name', $clinic));
        }

        $statusCount = (clone $base)
            ->reorder()
            ->selectRaw('status, COUNT(*) total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $listQuery = clone $base;
        if ($currentTab !== 'all') {
            $listQuery->where('status', AppointmentStatus::fromLabel($currentTab));
        }

        $appointments = $listQuery->latest('appointment_date')
            ->paginate(12)
            ->withQueryString();

        return view('doctor.antrian', compact(
            'appointments',
            'statusCount',
            'currentTab',
            'search',
            'clinic'
        ));
    }


    public function start(Appointment $appointment)
    {
        $this->authorize('update', $appointment);
        $appointment->update(['status' => AppointmentStatus::Upcoming]);
        return back()->withSuccess('Konsultasi dimulai.');
    }

    public function complete(Appointment $appointment)
    {
        if ($appointment->status !== AppointmentStatus::Upcoming) {
            return response('Already completed', 409);
        }

        $this->authorize('update', $appointment);
        $appointment->update(['status' => AppointmentStatus::Completed]);

        return back()->withSuccess('Konsultasi selesai.');
    }

    public function cancel(Appointment $appointment)
    {
        if ($appointment->status !== AppointmentStatus::Upcoming) {
            return response('Already canceled', 409);
        }

        $this->authorize('update', $appointment);
        $appointment->update(['status' => AppointmentStatus::Canceled]);
        return back()->withSuccess('Janji dibatalkan.');
    }
}
