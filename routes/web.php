<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
// Landing Page (accessible without login)
Route::view('/', 'landing');

// Dormitories List (accessible without login)
Route::view('/dormitories', 'dormitories');

// Login Page (accessible without login)
Route::view('/login', 'auth.login')->name('login');

// Handle Login POST
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Admin Functionality (requires login)
Route::middleware('auth')->group(function () {
    Route::view('/admin/dashboard', 'admin.dashboard')->name('dashboard');

    Route::get('/admin/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/admin/users', [UserController::class, 'store'])->name('users.store');
    Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
