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

        if ($user->role === 'admin') {

            $appointments = Appointment::with(['patient', 'clinic', 'doctor'])
                ->latest('appointment_date')
                ->paginate(15);                           // page lebih besar untuk admin

            $statusCount = Appointment::selectRaw('status, COUNT(*) total')
                ->groupBy('status')
                ->pluck('total', 'status');

            return view('tiket-antrian', compact('appointments', 'statusCount'));
        }

        if ($user->role === 'doctor') {

            $appointments = Appointment::with(['patient', 'clinic'])
                ->where('doctor_id', $user->id)
                ->latest('appointment_date')
                ->paginate(12);

            $statusCount = Appointment::where('doctor_id', $user->id)
                ->selectRaw('status, COUNT(*) total')
                ->groupBy('status')
                ->pluck('total', 'status');

            return view('tiket-antrian', compact('appointments', 'statusCount'));
        }

        $appointments = Appointment::with(['clinic'])
            ->where('user_id', $user->id)
            ->latest('appointment_date')
            ->paginate(12);

        $statusCount = Appointment::where('user_id', $user->id)
            ->selectRaw('status, COUNT(*) total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('tiket-antrian', compact('appointments', 'statusCount'));
    }


    public function antrianPasien()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {

            $appointments = Appointment::with(['patient', 'clinic', 'doctor'])
                ->latest('appointment_date')
                ->paginate(15);                           // page lebih besar untuk admin

            $statusCount = Appointment::selectRaw('status, COUNT(*) total')
                ->groupBy('status')
                ->pluck('total', 'status');

            return view('doctor.antrian', compact('appointments', 'statusCount'));
        }

        if ($user->role === 'doctor') {

            $appointments = Appointment::with(['patient', 'clinic'])
                ->where('doctor_id', $user->id)
                ->latest('appointment_date')
                ->paginate(12);

            $statusCount = Appointment::where('doctor_id', $user->id)
                ->selectRaw('status, COUNT(*) total')
                ->groupBy('status')
                ->pluck('total', 'status');

            return view('doctor.antrian', compact('appointments', 'statusCount'));
        }

        $appointments = Appointment::with(['clinic'])
            ->where('user_id', $user->id)
            ->latest('appointment_date')
            ->paginate(12);

        $statusCount = Appointment::where('user_id', $user->id)
            ->selectRaw('status, COUNT(*) total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('doctor.antrian', compact('appointments', 'statusCount'));
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
