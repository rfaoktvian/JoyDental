<?php

use App\Http\Controllers\AppointmentController;

Route::get('/polyclinic/{polyclinic}/doctors', [AppointmentController::class, 'getDoctorsByPolyclinic']);