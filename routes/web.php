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

Route::get('/janji-temu', fn() => view('janji-temu'))
  ->name('janji-temu');

Route::get('/dokter', fn() => view('dokter'))
  ->name('dokter');

Route::get('/poliklinik', fn() => view('poliklinik'))
  ->name('poliklinik');

Route::get('/tiket-antrian', fn() => view('tiket-antrian'))
  ->name('tiket-antrian');

Route::get('/bantuan', fn() => view('bantuan'))
  ->name('bantuan');

Route::prefix('admin')->middleware('admin')->group(function () {
  Route::get('/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');

  Route::get('/users', [AdminController::class, 'manageUsers'])->name('admin.users');
  Route::post('/users', [AdminController::class, 'store'])->name('admin.users.store');
  Route::put('/users/{id}', [AdminController::class, 'update'])->name('admin.users.update');
  Route::delete('/users/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
});

Route::prefix('doctor')->middleware('doctor')->group(function () {
  Route::get('/dashboard', fn() => view('doctor.dashboard'))->name('doctor.dashboard');
  Route::get('/jadwal', fn() => view('doctor.jadwal'))->name('doctor.jadwal');
  Route::get('/antrian', fn() => view('doctor.antrian'))->name('doctor.antrian');
});


View::share('hideNavRoutes', value: [
  'register',
  'login',
]);

View::share('poliklinikTypes', [
  1 => ['label' => 'Pediatric', 'class' => 'bg-danger-subtle text-danger'],
  2 => ['label' => 'Surgical', 'class' => 'bg-primary-subtle text-primary'],
  3 => ['label' => 'Cardiology', 'class' => 'bg-warning-subtle text-warning'],
  4 => ['label' => 'Ophthalmology', 'class' => 'bg-info-subtle text-info'],
  5 => ['label' => 'Neurology', 'class' => 'bg-purple-subtle text-purple'],
  6 => ['label' => 'Orthopedics', 'class' => 'bg-success-subtle text-success'],
  7 => ['label' => 'Dermatology', 'class' => 'bg-secondary-subtle text-secondary'],
  8 => ['label' => 'Internal Medicine', 'class' => 'bg-dark-subtle text-dark'],
  9 => ['label' => 'ENT', 'class' => 'bg-teal-subtle text-teal'],
  10 => ['label' => 'General Practice', 'class' => 'bg-light text-muted'],
]);