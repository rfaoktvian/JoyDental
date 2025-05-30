<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JanjiTemuController extends Controller
{
    public function create()
    {
        return view('janji-temu');
    }

    public function store(Request $request)
    {
        // validasi dan simpan data janji temu
    }
}
