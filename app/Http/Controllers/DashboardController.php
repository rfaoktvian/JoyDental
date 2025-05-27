<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Polyclinic;

class DashboardController extends Controller
{
    public function index()
    {
        $test = Polyclinic::inRandomOrder()->take(3)->get();
        return view('dashboard', compact('test'));
    }
}