<?php

use App\Http\Controllers\PoliklinikController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;

require base_path('routes/api.php');
require base_path('routes/front_end.php');
require base_path('routes/auth.php');

// Default route
Route::view('/', 'dashboard');
Route::get('/', [DashboardController::class, 'dashboard'])
  ->name('dashboard');

Route::get('/janji-temu', [AppointmentController::class, 'janjitemu'])
  ->name('janji-temu');

Route::middleware(['auth'])
  ->post('/janji-temu', [AppointmentController::class, 'store'])
  ->name('janji-temu.store');


Route::post(
  '/antrian/{appointment}/cancel',
  [AppointmentController::class, 'cancel']
)
  ->name('antrian.cancel');

Route::get(
  '/doctor/antrian/{appointment}/reschedule',
  [AppointmentController::class, 'reschedule']
)->name('antrian.reschedule');

Route::patch(
  '/doctor/antrian/{appointment}/reschedule',
  [AppointmentController::class, 'saveReschedule']
)->name('antrian.reschedule.simpan');

Route::get('/rekam-medis', fn() => view('rekam-medis'))
  ->name('rekam-medis');

Route::middleware(['auth'])
  ->get('/tiket-antrian', [AppointmentController::class, 'tiketAntrian'])
  ->name('tiket-antrian');


use App\Http\Controllers\DoctorController;
use Illuminate\Support\Facades\Response;
Route::get('/dokter', [DoctorController::class, 'index'])->name('dokter');

Route::get('/poliklinik', [PoliklinikController::class, 'index'])->name('poliklinik');

Route::get('/bantuan', fn() => view('bantuan'))
  ->name('bantuan');

Route::get('/profil', [UserController::class, 'profileUser'])
  ->name('profil');
Route::put('/profil', [UserController::class, 'updateProfileUser'])
  ->name('profil.update');



Route::get('/doctor/{doctor}/schedule', [DoctorController::class, 'getScheduleForm'])
  ->name('doctor.get.schedule');
Route::get('/doctor/{doctor}/reviews', [DoctorController::class, 'getReviews'])
  ->name('doctor.get.reviews');

Route::get('/api/doctor/{doctor}/schedule', function (\App\Models\Doctor $doctor) {
  return $doctor->schedules
    ->map(fn($s) => [
      'day' => $s->day,
      'from' => $s->time_from,
      'to' => $s->time_to,
    ]);
});

Route::prefix('doctor')
  ->middleware(['auth', 'doctor'])
  ->name('doctor.')
  ->group(function () {
    Route::get('/', [DashboardController::class, 'doctorDashboard'])->name('dashboard');

    Route::get('/antrian', [AppointmentController::class, 'antrianPasien'])
      ->name('antrian');
    Route::get('/laporan', [DoctorController::class, 'laporan'])
      ->name('laporan');
    Route::get('/riwayat', [DoctorController::class, 'riwayat'])
      ->name('riwayat');

    Route::put('/profile/{id}', [DoctorController::class, 'updateProfileDoctor'])
      ->name('profile.update');
    Route::get('/profile', [DoctorController::class, 'profileDoctor'])
      ->name('profile');

    Route::post(
      '/antrian/{appointment}/start',
      [AppointmentController::class, 'start']
    )
      ->name('antrian.start');

    Route::post(
      '/antrian/{appointment}/complete',
      [AppointmentController::class, 'complete']
    )
      ->name('antrian.complete');


    Route::fallback(function () {
      if (request()->is('doctor/*') && auth()->check()) {
        return redirect('/');
      }
      abort(404);
    });
    app('router')->getMiddleware()['doctor'] = function ($request, $next) {
      if (!auth()->check()) {
        return redirect('/');
      }
      return $next($request);
    };
  });


// Test Midtrans Configuration
Route::get('/test-midtrans', function() {
    try {
        $config = [
            'merchant_id' => config('midtrans.merchant_id'),
            'client_key' => config('midtrans.client_key'),
            'server_key' => config('midtrans.server_key'),
            'is_production' => config('midtrans.is_production'),
        ];
        
        // Sensor untuk keamanan
        if ($config['client_key']) {
            $config['client_key_preview'] = substr($config['client_key'], 0, 20) . '***';
        }
        if ($config['server_key']) {
            $config['server_key_preview'] = substr($config['server_key'], 0, 20) . '***';
        }
        
        // Test koneksi ke Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        
        return response()->json([
            'status' => 'OK',
            'config' => [
                'merchant_id' => $config['merchant_id'],
                'client_key' => $config['client_key_preview'] ?? 'NOT SET',
                'server_key' => $config['server_key_preview'] ?? 'NOT SET',
                'is_production' => $config['is_production'] ? 'true' : 'false',
            ],
            'midtrans_class_exists' => class_exists('\Midtrans\Snap'),
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'ERROR',
            'message' => $e->getMessage()
        ], 500);
    }
  })->middleware('auth');  

// Payment Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/payment/{order}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/{order}/process', [PaymentController::class, 'process'])->name('payment.process');
    Route::get('/payment/{order}/finish', [PaymentController::class, 'finish'])->name('payment.finish');
});

// Webhook dari Midtrans 
Route::post('/payment/webhook', [PaymentController::class, 'webhook'])->name('payment.webhook');



Route::prefix('admin')->middleware('admin')->group(function () {
  Route::get('/', fn() => redirect('/'))->name('admin.dashboard');

  Route::get('/users/add', [AdminController::class, 'addUserForm'])->name('admin.users.create');
  Route::get('/users/{id}/edit', [AdminController::class, 'editUserForm'])->name('admin.users.edit');
  Route::get('/users', [AdminController::class, 'manageUsers'])->name('admin.users');
  Route::post('/users', [AdminController::class, 'store'])->name('admin.users.store');
  Route::put('/users/{id}', [AdminController::class, 'update'])->name('admin.users.update');
  Route::delete('/users/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy');

  Route::get('/dokter/add', [AdminController::class, 'addDoctorForm'])->name('admin.dokter.create');
  Route::get('/dokter/{id}/edit', [AdminController::class, 'editDoctorForm'])->name('admin.dokter.edit');
  Route::get('/dokter', [AdminController::class, 'manageDoctors'])->name('admin.dokter');

  Route::put('/dokter/{id}/update', [AdminController::class, 'updateDoctor'])->name('admin.dokter.update');
  Route::delete('/dokter/{id}/destroy', [AdminController::class, 'destroyDoctor'])->name('admin.dokter.destroy');


  Route::get('/poliklinik/add', [AdminController::class, 'addPolyclinicForm'])->name('admin.poliklinik.create');
  Route::get('/poliklinik/{id}/edit', [AdminController::class, 'editPolyclinicForm'])->name('admin.poliklinik.edit');
  Route::get('/poliklinik', [AdminController::class, 'managePolyclinics'])->name('admin.poliklinik');

  Route::put('/poliklinik/{id}/update', [AdminController::class, 'updatePolyclinic'])->name('admin.poliklinik.update');
  Route::delete('/poliklinik/{id}/destroy', [AdminController::class, 'destroyPolyclinic'])->name('admin.poliklinik.destroy');
  Route::post('/admin/poliklinik/store', [AdminController::class, 'storePolyclinic'])->name('admin.poliklinik.store');


  Route::fallback(function () {
    if (request()->is('admin/*') && auth()->check()) {
      return redirect('/');
    }
    abort(404);
  });
  app('router')->getMiddleware()['admin'] = function ($request, $next) {
    if (!auth()->check()) {
      return redirect('/');
    }
    return $next($request);
  };
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

Route::middleware(['auth'])->group(function () {

  // Main report page (existing route - make sure it exists)
  Route::get('/laporan', [DoctorController::class, 'laporan'])->name('laporan');

  // Export functionality
  Route::post('/laporan/export', [DoctorController::class, 'exportReport'])->name('laporan.export');

  // AJAX endpoint for real-time dashboard data
  Route::get('/api/dashboard-data', [DoctorController::class, 'getDashboardData'])->name('dashboard.data');

  // Additional API endpoints for enhanced functionality
  Route::get('/api/chart-data', [DoctorController::class, 'getChartData'])->name('chart.data');
  Route::get('/api/appointments-by-date', [DoctorController::class, 'getAppointmentsByDate'])->name('appointments.by-date');
});
