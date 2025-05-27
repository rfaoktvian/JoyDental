<?php

use App\Http\Controllers\Auth\LoginController;
use App\Models\User;

Route::get('login', [LoginController::class, 'showLoginForm'])
  ->name('login');

Route::post('login', [LoginController::class, 'login']);
Auth::routes();


Route::get('/check-nik', function (Request $req) {
  return User::where('nik', $req->query('nik'))->exists()
    ? response()->noContent()
    : response()->json([], 404);
})->name('check.nik');

