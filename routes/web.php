<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OwnerController;

use App\Http\Controllers\CommitteeDormitoryController;
use App\Http\Controllers\CommitteeDashboardController;

// Landing Page (accessible without login)
Route::view('/', 'landing');

// Dormitories List (accessible without login)
Route::view('/dormitories', 'dormitories');

// Registration for Dormitory Owner
Route::get('/registration', function () {return view('dorm_owner_registration');})->name('register-dorm-owner');
Route::post('/owner/register', [OwnerController::class, 'register'])->name('owner.register');

// Login Page (accessible without login)
Route::view('/login', 'auth.login')->name('login');

// Handle Login POST
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Admin Functionality (requires login)
Route::middleware('auth')->group(function () {
    // Admin Routes
    Route::view('/admin/dashboard', 'admin.dashboard')->name('dashboard');
    Route::get('/admin/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/admin/users', [UserController::class, 'store'])->name('users.store');
    Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // Committee Routes
    Route::get('/committee/dashboard', [CommitteeDashboardController::class, 'index'])->name('committee.dashboard');
    Route::get('/committee/dormitories', [CommitteeDormitoryController::class, 'index'])->name('committee.dormitories');
    Route::post('/committee/dormitories', [CommitteeDormitoryController::class, 'store'])->name('committee.dormitories.store');
    Route::delete('/committee/dormitories/{id}', [CommitteeDormitoryController::class, 'destroy'])->name('committee.dormitories.destroy');

    // Logout Route
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
