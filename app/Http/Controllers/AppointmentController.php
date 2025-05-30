<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Enums\AppointmentStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AppointmentController extends Controller
{
    public function tiketAntrian()
    {
        $user = Auth::user();
        $currentTab = request('tab', 'all');
        $search = request('q');
        $clinic = request('clinic');

        $base = Appointment::with(['clinic'])
            ->where('user_id', $user->id);

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

        $ongoing = (clone $base)
            ->where('status', AppointmentStatus::Upcoming)
            ->latest('appointment_date')
            ->paginate(3, ['*'], 'ongoing_page')
            ->withQueryString();

        $appointments = $listQuery->latest('appointment_date')
            ->paginate(12)
            ->withQueryString();

        return view('tiket-antrian', compact(
            'ongoing',
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
            $doctorId = optional($user->doctor)->id;
            $doctorId = $doctorId ?? 0;

            $base = Appointment::with(['patient', 'clinic', 'doctor'])
                ->where('doctor_id', $doctorId);
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

    public function reschedule(Request $request, Appointment $appointment)
    {
        $this->authorize('update', $appointment);
        $appointment->load(['clinic', 'doctor']);


        if (!$request->header('HX-Request')) {
            return redirect()->route('tiket-antrian');
        }
        return view('partials.reschedule-form', [
            'appt' => $appointment,
        ]);

    }

    public function saveReschedule(Request $request, Appointment $appointment)
    {
        $this->authorize('update', $appointment);

        $data = $request->validate([
            'date' => ['required', 'date', 'after_or_equal:today'],
            'time' => ['required', 'date_format:H:i'],
        ]);

        $exists = Appointment::where('doctor_id', $appointment->doctor_id)
            ->whereDate('appointment_date', $data['date'])
            ->whereTime('appointment_time', $data['time'])
            ->where('status', '!=', AppointmentStatus::Canceled)
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'date' => 'Slot tersebut sudah diambil, silakan pilih waktu lain.'
            ])->withInput();
        }

        $appointment->update([
            'appointment_date' => Carbon::parse($data['date']),
            'appointment_time' => Carbon::parse($data['time']),
            'status' => AppointmentStatus::Upcoming,
        ]);

        return response('<div class="text-center p-4 text-success">Jadwal Berhasil Diperbarui</div>', 200);
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
