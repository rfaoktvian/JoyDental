<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Polyclinic;
use App\Models\Doctor;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function editUserForm(Request $request, $id)
    {
        $user = User::findOrFail($id);
        return view('partials.account-form', data: compact('user'));
    }

    public function editDoctorForm(Request $request, $id)
    {
        $doctor = Doctor::with(['user', 'schedules', 'reviews'])->findOrFail($id);
        return view('partials.doctor-form', compact('doctor'));
    }

    public function editPolyclinicForm(Request $request, $id)
    {
        $polyclinic = Polyclinic::findOrFail($id);
        return view('partials.polyclinic-form', compact('polyclinic'));
    }
    public function addUserForm(Request $request)
    {
        return view('partials.add-user-form');
    }

    public function addDoctorForm(Request $request)
    {
        return view('partials.add-doctor-form');
    }

    public function addPolyclinicForm(Request $request)
    {
        return view('partials.add-polyclinic-form');
    }

    public function updateDoctor(Request $request, $id)
    {
        $doctor = Doctor::with('user', 'schedules')->findOrFail($id);

        $validatedUserData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email'
        ]);

        $doctor->user->update([
            'name' => $validatedUserData['name'],
            'email' => $validatedUserData['email']
        ]);

        // Update schedules
        $schedulesInput = $request->input('schedules', []);

        foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day) {
            $data = $schedulesInput[$day] ?? null;
            if ($data && isset($data['active'])) {
                // Find existing schedule for this day
                $schedule = $doctor->schedules()->where('day', $day)->first();
                if (!$schedule) {
                    // Create a new schedule
                    $schedule = $doctor->schedules()->create([
                        'day' => $day,
                        'time_from' => $data['time_from'] ?? null,
                        'time_to' => $data['time_to'] ?? null,
                        'max_capacity' => $data['max_capacity'] ?? 0,
                        'polyclinic_id' => $data['polyclinic_id'] ?? null
                    ]);
                } else {
                    // Update existing schedule
                    $schedule->update([
                        'time_from' => $data['time_from'] ?? null,
                        'time_to' => $data['time_to'] ?? null,
                        'max_capacity' => $data['max_capacity'] ?? 0,
                        'polyclinic_id' => $data['polyclinic_id'] ?? null
                    ]);
                }
            } else {
                // If inactive, delete schedule if exists
                $doctor->schedules()->where('day', $day)->delete();
            }
        }
        $doctor->touch();

        return back()->with('success', 'Jadwal dokter berhasil diperbarui.');
    }


    public function destroyDoctor($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->schedules()->delete();
        $doctor->delete();

        return back()->with('success', 'Dokter berhasil dihapus.');
    }

    public function updatePolyclinic(Request $request, $id)
    {
        $polyclinic = Polyclinic::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1'
        ]);

        $polyclinic->update($validatedData);

        return back()->with('success', 'Poliklinik berhasil diperbarui.');
    }

    public function destroyPolyclinic($id)
    {
        $polyclinic = Polyclinic::findOrFail($id);
        $polyclinic->delete();

        return redirect()->route('admin.poliklinik')->with('success', 'Poliklinik berhasil dihapus.');
    }

    public function storePolyclinic(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
        ]);

        // Auto-increment type field based on current max
        $maxType = Polyclinic::max('type') ?? 0;
        $newType = $maxType + 1;

        $polyclinic = Polyclinic::create([
            'name' => $validatedData['name'],
            'location' => $validatedData['location'],
            'type' => $newType,
            'capacity' => $validatedData['capacity'],
        ]);

        return back();
    }
    public function manageUsers(Request $request)
    {
        $query = User::query();

        if ($request->filled('filter_role')) {
            $roles = is_array($request->filter_role)
                ? $request->filter_role
                : [$request->filter_role];
            $query->whereIn('role', $roles);
        }

        if ($request->filled('search')) {
            $keyword = "%{$request->search}%";
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', $keyword)
                    ->orWhere('email', 'like', $keyword)
                    ->orWhere('nik', 'like', $keyword);
            });
        }

        if ($request->filled('sort_by')) {
            $order = $request->sort_order === 'desc' ? 'desc' : 'asc';
            $query->orderBy($request->sort_by, $order);
        }

        $users = $query->paginate(12);

        return view('admin.user', compact('users'));
    }


    public function manageDoctors(Request $request)
    {
        $query = Doctor::query()->with(['user', 'schedules', 'reviews']);

        if ($request->filled('search')) {
            $keyword = "%{$request->search}%";
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', $keyword)
                    ->orWhere('nik', 'like', $keyword)
                    ->orWhere('specialization', 'like', $keyword);
            });
        }

        if ($request->filled('sort_by')) {
            $order = $request->sort_order === 'desc' ? 'desc' : 'asc';
            $query->orderBy($request->sort_by, $order);
        } else {
            $query->orderBy('name');
        }

        $doctors = $query->paginate(12);

        return view('admin.dokter', compact('doctors'));
    }


    public function managePolyclinics(Request $request)
    {
        $query = Polyclinic::query();

        if ($request->filled('search')) {
            $keyword = "%{$request->search}%";
            $query->where('name', 'like', $keyword)
                ->orWhere('location', 'like', $keyword);
        }

        if ($request->filled('sort_by')) {
            $order = $request->sort_order === 'desc' ? 'desc' : 'asc';
            $query->orderBy($request->sort_by, $order);
        } else {
            $query->orderBy('name');
        }

        $polyclinics = $query->paginate(12);

        return view('admin.poliklinik', compact('polyclinics'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|email',
            'nik' => 'required|string|unique:users,nik',
            'password' => 'required|string|min:8'
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'nik' => $validatedData['nik'],
            'password' => Hash::make($validatedData['password'])
        ]);
        return back();
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:user,doctor,admin'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return back();
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')->with('error', 'Tidak dapat menghapus akun sendiri!');
        }

        $user->delete();
        return back();
    }
}
