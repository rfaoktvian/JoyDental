<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Enums\AppointmentStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use App\Models\Polyclinic;
use App\Models\Doctor;
use App\Models\DoctorSchedule;

class AppointmentController extends Controller
{
    public function janjitemu()
    {
        $user = auth()->user();

        $polyclinics = Polyclinic::orderBy('name')->get();
        return view('janji-temu', compact('polyclinics', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'polyclinic' => ['required', 'exists:polyclinics,id'],
            'doctor' => ['required', 'exists:doctors,id'],
            'visit_date' => ['required', 'date', 'after_or_equal:today'],
            'time' => ['required', 'date_format:H:i'],
            'payment_method' => ['required', 'in:cash,credit_card,e_wallet'],
            'complaint' => ['required', 'string', 'max:1000'],
        ]);

        $user = Auth::user();
        $polyclinicId = $request->input('polyclinic');
        $doctorId = $request->input('doctor');
        $visitDate = Carbon::parse($request->input('visit_date'))->toDateString();
        $visitTime = $request->input('time');
        $payment = $request->input('payment_method');
        $complaint = $request->input('complaint');

        $dayName = Carbon::parse($visitDate)
            ->locale('id')
            ->translatedFormat('l');

        $schedule = DoctorSchedule::where('doctor_id', $doctorId)
            ->where('polyclinic_id', $polyclinicId)
            ->where('day', $dayName)
            ->first();

        if (!$schedule) {
            return back()
                ->withInput()
                ->withErrors(['visit_date' => "Dokter tidak praktik pada hari “{$dayName}”."]);
        }

        $existingCount = Appointment::where('doctor_schedule_id', $schedule->id)
            ->whereDate('appointment_date', $visitDate)
            ->count();

        $queueNumber = 'Q' . str_pad($existingCount + 1, 3, '0', STR_PAD_LEFT);

        $bookingCode = Str::upper(Str::random(8));

        $appt = Appointment::create([
            'queue_number' => $queueNumber,
            'booking_code' => $bookingCode,
            'user_id' => $user->id,
            'doctor_id' => $doctorId,
            'doctor_schedule_id' => $schedule->id,
            'status' => 1,
            'appointment_date' => $visitDate,
            'appointment_time' => $visitTime . ':00',
            'payment_method' => $payment,
            'consultation_fee' => $schedule->doctor->consultation_fee ?? null,
            'chief_complaint' => $complaint,
        ]);

        return redirect()->route('tiket-antrian')
            ->with('success', "Janji temu berhasil dibuat. Kode Booking: “{$bookingCode}”");
    }

    public function getDoctorsByPolyclinic(Polyclinic $polyclinic)
    {

        $doctors = Doctor::whereHas('schedules', function ($q) use ($polyclinic) {
            $q->where('polyclinic_id', $polyclinic->id);
        })
            ->with([
                'schedules' => function ($q) use ($polyclinic) {
                    $q->where('polyclinic_id', $polyclinic->id);
                }
            ])
            ->get();

        $result = $doctors->map(function ($doc) {
            return [
                'id' => $doc->id,
                'name' => $doc->name,
                'specialization' => $doc->specialization,
                'photo' => $doc->photo,
                'schedules' => $doc->schedules->map(function ($s) {
                    return [
                        'schedule_id' => $s->id,
                        'day' => $s->day,
                        'time_from' => substr($s->time_from, 0, 5),
                        'time_to' => substr($s->time_to, 0, 5),
                        'max_capacity' => $s->max_capacity,
                    ];
                })->values(),
            ];
        });

        return response()->json(data: $result);
    }

    public function tiketAntrian()
    {
        $user = Auth::user();

        Appointment::where('status', 1)
            ->where(function ($query) {
                $query->where('appointment_date', '<', now()->toDateString())
                    ->orWhere(function ($q) {
                        $q->whereDate('appointment_date', now()->toDateString())
                            ->whereRaw('appointment_time < TIME(NOW())');
                    });
            })
            ->update(['status' => 3]);

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

        Appointment::where('status', 1)
            ->where(function ($query) {
                $query->where('appointment_date', '<', now()->toDateString())
                    ->orWhere(function ($q) {
                        $q->whereDate('appointment_date', now()->toDateString())
                            ->whereRaw('appointment_time < TIME(NOW())');
                    });
            })
            ->update(['status' => 3]);

        $currentTab = request('tab', 'all');
        $search = request('q');
        $clinic = request('clinic');

        if ($user->role === 'admin') {
            $base = Appointment::with(['patient', 'clinic', 'doctor']);
        } elseif ($user->role === 'doctor') {
            $doctorId = optional($user->doctor)->id ?? 0;
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

        return back();
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
