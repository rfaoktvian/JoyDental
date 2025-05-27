<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

// Importing routes from other files
Route::middleware('web')
  ->group(base_path('routes/front_end.php'))
  ->group(base_path('routes/auth.php'));

// Default route
Route::view('/', 'dashboard');
Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])
  ->name('dashboard');

use App\Http\Controllers\PoliklinikController;
Route::get('/poliklinik', [PoliklinikController::class, 'index'])->name('poliklinik');

Route::get('/janji-temu', fn() => view('janji-temu'))
  ->name('janji-temu');


use App\Http\Controllers\DoctorController;
Route::get('/dokter', [DoctorController::class, 'index'])->name('dokter');


Route::get('/tiket-antrian', fn() => view('tiket-antrian'))
  ->name('tiket-antrian');

Route::get('/bantuan', fn() => view('bantuan'))
  ->name('bantuan');

Route::prefix('admin')->middleware('admin')->group(function () {
  Route::get('/', fn() => view('admin.dashboard'))->name('admin.dashboard');

  Route::get('/users', [AdminController::class, 'manageUsers'])->name('admin.users');
  Route::post('/users', [AdminController::class, 'store'])->name('admin.users.store');
  Route::put('/users/{id}', [AdminController::class, 'update'])->name('admin.users.update');
  Route::delete('/users/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
});

Route::prefix('doctor')->middleware('doctor')->group(function () {
  Route::get('/', fn() => view('doctor.dashboard'))->name('doctor.dashboard');
  Route::get('/jadwal', fn() => view('doctor.jadwal'))->name('doctor.jadwal');
  Route::get('/antrian', fn() => view('doctor.antrian'))->name('doctor.antrian');
});


View::share('hideNavRoutes', value: [
  'register',
  'login',
]);

View::share('poliklinikTypes', [
  1 => ['label' => 'General Practice', 'class' => 'bg-light text-muted', 'icon' => 'fa-user-md'],
  2 => ['label' => 'Pediatric', 'class' => 'bg-danger-subtle text-danger', 'icon' => 'fa-baby'],
  3 => ['label' => 'Dental', 'class' => 'bg-primary-subtle text-primary', 'icon' => 'fa-tooth'],
  4 => ['label' => 'Surgical', 'class' => 'bg-warning-subtle text-warning', 'icon' => 'fa-scissors'],
  5 => ['label' => 'Cardiology', 'class' => 'bg-info-subtle text-info', 'icon' => 'fa-heartbeat'],
  6 => ['label' => 'ENT', 'class' => 'bg-teal-subtle text-teal', 'icon' => 'fa-ear-listen'],
  7 => ['label' => 'Ophthalmology', 'class' => 'bg-info-subtle text-info', 'icon' => 'fa-eye'],
  8 => ['label' => 'Neurology', 'class' => 'bg-purple-subtle text-purple', 'icon' => 'fa-brain'],
  9 => ['label' => 'Dermatology', 'class' => 'bg-secondary-subtle text-secondary', 'icon' => 'fa-allergies'],
  10 => ['label' => 'Internal Medicine', 'class' => 'bg-dark-subtle text-dark', 'icon' => 'fa-stethoscope'],
  11 => ['label' => 'Nutrition', 'class' => 'bg-success-subtle text-success', 'icon' => 'fa-apple-whole'],
  12 => ['label' => 'Rehabilitation', 'class' => 'bg-primary-subtle text-primary', 'icon' => 'fa-dumbbell'],
  13 => ['label' => 'Psychology', 'class' => 'bg-warning-subtle text-warning', 'icon' => 'fa-comments'],
  14 => ['label' => 'Clinical Nutrition', 'class' => 'bg-info-subtle text-info', 'icon' => 'fa-carrot'],
  15 => ['label' => 'Urology', 'class' => 'bg-teal-subtle text-teal', 'icon' => 'fa-microscope'],
  16 => ['label' => 'Immunology', 'class' => 'bg-purple-subtle text-purple', 'icon' => 'fa-syringe'],
  17 => ['label' => 'Infectious Disease', 'class' => 'bg-danger-subtle text-danger', 'icon' => 'fa-virus'],
  18 => ['label' => 'Allergy', 'class' => 'bg-success-subtle text-success', 'icon' => 'fa-head-side-cough'],
  19 => ['label' => 'Child Development', 'class' => 'bg-warning-subtle text-warning', 'icon' => 'fa-child'],
  20 => ['label' => 'Emergency', 'class' => 'bg-danger-subtle text-danger', 'icon' => 'fa-ambulance'],
  21 => ['label' => 'Radiology', 'class' => 'bg-dark-subtle text-dark', 'icon' => 'fa-x-ray'],
  22 => ['label' => 'Anesthesiology', 'class' => 'bg-secondary-subtle text-secondary', 'icon' => 'fa-bed'],
  23 => ['label' => 'Laboratory', 'class' => 'bg-info-subtle text-info', 'icon' => 'fa-vials'],
  24 => ['label' => 'Nephrology', 'class' => 'bg-primary-subtle text-primary', 'icon' => 'fa-tint'],
  25 => ['label' => 'Hematology', 'class' => 'bg-purple-subtle text-purple', 'icon' => 'fa-droplet'],
  26 => ['label' => 'Psychiatry', 'class' => 'bg-secondary-subtle text-secondary', 'icon' => 'fa-face-smile'],
  27 => ['label' => 'Gastroenterology', 'class' => 'bg-teal-subtle text-teal', 'icon' => 'fa-notes-medical'],
  28 => ['label' => 'Neurosurgery', 'class' => 'bg-warning-subtle text-warning', 'icon' => 'fa-user-injured'],
  29 => ['label' => 'Reproductive Health', 'class' => 'bg-danger-subtle text-danger', 'icon' => 'fa-venus-mars'],
  30 => ['label' => 'Gynecology', 'class' => 'bg-pink-subtle text-pink', 'icon' => 'fa-female'],
]);