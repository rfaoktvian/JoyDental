<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with('schedules.polyclinic', 'reviews')->get();
        return view('dokter', compact('doctors'));
    }
}
