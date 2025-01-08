<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OwnerRegistrationController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\CommitteeDormitoryController;
use App\Http\Controllers\CommitteeDashboardController;
use App\Http\Controllers\CommitteeCriteriaController;

use App\Http\Controllers\Owner\DormitoryController;
use App\Http\Controllers\Owner\EvaluationController;

// Landing Page (accessible without login)
Route::view('/', 'landing');

// Dormitories List (accessible without login)
Route::view('/dormitories', 'dormitories');

// Registration for Dormitory Owner
Route::get('/registration', function () {return view('dorm_owner_registration');})->name('register-dorm-owner');
Route::post('/owner/register', [OwnerRegistrationController::class, 'store'])->name('owner.register');

// Login Page (accessible without login)
Route::view('/login', 'auth.login')->name('login');

// Handle Login POST
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Admin Functionality (requires login)
Route::middleware('auth')->group(function () {
    // Profule Route
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Admin Routes
    Route::view('/admin/dashboard', 'admin.dashboard')->name('dashboard');
    Route::get('/admin/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/admin/users', [UserController::class, 'store'])->name('users.store');
    Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // Committee Routes
    // Dashboard Module
    Route::get('/committee/dashboard', [CommitteeDashboardController::class, 'index'])->name('committee.dashboard');

    // Dormitories Module
    Route::get('/committee/dormitories', [CommitteeDormitoryController::class, 'index'])->name('committee.dormitories');
    Route::post('/committee/dormitories', [CommitteeDormitoryController::class, 'store'])->name('committee.dormitories.store');
    Route::delete('/committee/dormitories/{id}', [CommitteeDormitoryController::class, 'destroy'])->name('committee.dormitories.destroy');

    // Criteria Module
    Route::get('/committee/criteria', [CommitteeCriteriaController::class, 'index'])->name('criteria.index');
    Route::post('/committee/criteria/column', [CommitteeCriteriaController::class, 'saveColumn'])->name('criteria.column.save');
    Route::post('/committee/criteria/row', [CommitteeCriteriaController::class, 'saveRow'])->name('criteria.row.save');
    Route::delete('/committee/criteria/row/{id}', [CommitteeCriteriaController::class, 'deleteRow'])->name('criteria.row.delete');

    // Owner
    // Links
    Route::view('/dashboard', 'owner.dashboard')->name('owner.dashboard');
    Route::view('/inspection', 'owner.dashboard')->name('owner.inspection');
    Route::view('/account', 'owner.account')->name('owner.account');
    Route::view('/security', 'owner.security')->name('owner.security');
    Route::view('/monitoring', 'owner.monitoring')->name('owner.monitoring');

    // Dormitory Module
    Route::get('dormitories', [DormitoryController::class, 'index'])->name('dormitories.index');
    Route::get('dormitories/{id}', [DormitoryController::class, 'show'])->name('dormitories.show');

    // Evaluation Module
    Route::get('/evaluation', [EvaluationController::class, 'index'])->name('evaluation.index');
    Route::get('/evaluation/{id}', [EvaluationController::class, 'show'])->name('evaluation.show');

    // Logout Route
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
