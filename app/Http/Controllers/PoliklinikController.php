<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Polyclinic;

class PoliklinikController extends Controller
{
    public function index()
    {
        $polyclinics = Polyclinic::all();
        return view('poliklinik', compact('polyclinics'));
    }
}
