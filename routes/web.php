<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Landing Page
Route::view('/', 'landing');

// Dormitories List
Route::view('/dormitories', 'dormitories');

// Login Page
Route::view('/login', 'auth.login')->name('login');

// Handle Login POST
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Admin Dashboard
Route::view('/admin/dashboard', 'admin.dashboard')->name('dashboard');
