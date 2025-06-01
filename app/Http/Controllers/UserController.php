<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;

class UserController extends Controller
{
    public function profileUser(Request $request)
    {
        $user = auth()->user();

        $totalAppointments = Appointment::where('user_id', $user->id)->count();
        $completedAppointments = Appointment::where('user_id', $user->id)
            ->where('status', 2)
            ->count();
        $upcomingAppointments = Appointment::where('user_id', $user->id)
            ->where('status', 1)
            ->count();

        $recentAppointment = Appointment::where('user_id', $user->id)
            ->latest('appointment_date')
            ->with(['doctor'])
            ->first();

        return view('profil', compact(
            'user',
            'totalAppointments',
            'completedAppointments',
            'upcomingAppointments',
            'recentAppointment'
        ));
    }

    public function updateProfileUser(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'nullable|integer|min:0',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $user->update($validated);

        return redirect()->route('user.profil')->with('success', 'Profile updated successfully!');
    }
}
