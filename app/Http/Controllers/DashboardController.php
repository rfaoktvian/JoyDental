<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Polyclinic;
use App\Models\Doctor;

class DashboardController extends Controller
{
    public function index()
    {
        $polyclinics = Polyclinic::inRandomOrder()->take(3)->get();
        $doctors = Doctor::select('doctors.*')
            ->leftJoin('doctor_reviews', 'doctors.id', '=', 'doctor_reviews.doctor_id')
            ->selectRaw('AVG(doctor_reviews.rating) as avg_rating')
            ->groupBy('doctors.id')
            ->orderByDesc('avg_rating')
            ->take(value: 3)
            ->get();

        return view('dashboard', compact('polyclinics', 'doctors'));
    }
}