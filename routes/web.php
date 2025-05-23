<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OwnerRegistrationController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\CommitteeDormitoryController;
use App\Http\Controllers\CommitteeDashboardController;
use App\Http\Controllers\CommitteeCriteriaController;
use App\Http\Controllers\CommitteeEvaluationController;

use App\Http\Controllers\AdminDormController;

use App\Http\Controllers\Owner\DormitoryController;
use App\Http\Controllers\Owner\EvaluationController;

use App\Http\Controllers\DormController;

use App\Http\Controllers\EvaluationCriteriaRatingController;

// Landing Page (accessible without login)
Route::view('/', 'landing');

// Replace the static view route for dormitories with a dynamic route
Route::get('/view-dormitories', [DormController::class, 'index'])->name('dormitories.view');
Route::get('/view-dormitories/{id}', [DormController::class, 'show'])->name('public.dormitories.show');

// Registration for Dormitory Owner
Route::get('/registration', [OwnerRegistrationController::class, 'show'])->name('register-dorm-owner');
Route::post('/owner/register', [OwnerRegistrationController::class, 'store'])->name('owner.register');

Route::get('/registration/thank-you', function () {
    return view('thank_you');
})->name('thank.you');

// User Registration
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('auth.register.form');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

// Login Page (accessible without login)
Route::view('/login', 'auth.login')->name('login');
// Handle Login POST
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Admin Functionality (requires login)
Route::middleware('auth')->group(function () {
    // Admin Modules - Dormitories
    Route::get('/dorm-listing', [AdminDormController::class, 'index'])->name('admin.dorm.listing');
    Route::get('/dorm-create', [AdminDormController::class, 'create'])->name('admin.dorm.create');

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
    // Admin Modules
    Route::get('/dormitories/create', [AdminDormController::class, 'create'])->name('dormitories.create');
    Route::post('/dormitories/import', [AdminDormController::class, 'import'])->name('dormitories.import');
    Route::post('/admin/dormitories/import', [AdminDormController::class, 'import'])->name('dormitories.import');
    Route::post('/dormitories/assign-committee', [AdminDormController::class, 'assignCommittee'])->name('dormitories.assignCommittee');
    
    Route::get('/committee/dormitories', [CommitteeDormitoryController::class, 'index'])->name('committee.dormitories');
    Route::post('/committee/dormitories', [CommitteeDormitoryController::class, 'store'])->name('committee.dormitories.store');
    Route::delete('/committee/dormitories/{id}', [CommitteeDormitoryController::class, 'destroy'])->name('committee.dormitories.destroy');
    Route::get('/committee/dormitories/{id}', [CommitteeDormitoryController::class, 'show'])->name('committee.dormitories.show');
    Route::post('/committee/dormitories/{id}/approve', [CommitteeDormitoryController::class, 'approve'])->name('committee.dormitories.approve');
    Route::post('/committee/dormitories/{id}/decline', [CommitteeDormitoryController::class, 'decline'])->name('committee.dormitories.decline');
    Route::post('/committee/send-invitation', [CommitteeDormitoryController::class, 'sendInvitation'])->name('committee.sendInvitation');

    // Criteria Module
    Route::get('/committee/criteria', [CommitteeCriteriaController::class, 'index'])->name('criteria.index');
    Route::post('/committee/criteria/row', [CommitteeCriteriaController::class, 'addRow'])->name('criteria.row.add');
    Route::post('/committee/criteria/column', [CommitteeCriteriaController::class, 'addColumn'])->name('criteria.column.add');
    Route::delete('/committee/criteria/row/{id}', [CommitteeCriteriaController::class, 'deleteRow'])->name('criteria.row.delete');
    Route::post('/committee/criteria/row/update', [CommitteeCriteriaController::class, 'updateCell'])->name('criteria.row.update');
    Route::post('/committee/criteria/save', [CommitteeCriteriaController::class, 'saveChanges'])->name('criteria.save.changes');
    Route::post('/criteria/toggle-status', [CommitteeCriteriaController::class, 'toggleStatus'])->name('criteria.toggle.status');
    Route::post('/committee/criteria/import', [CommitteeCriteriaController::class, 'import'])->name('criteria.import');
    Route::post('/committee/criteria/restore/{batchId}', [CommitteeCriteriaController::class, 'restore'])->name('criteria.restore');
    Route::get('/committee/criteria/preview/{batchId}', [CommitteeCriteriaController::class, 'preview'])->name('criteria.preview');

    // Evaluation Module 
    Route::post('/committee/evaluation/submit', [EvaluationController::class, 'submit'])->name('evaluation.submit');
    Route::get('/committee/evaluation/review/{schedule_id}', [EvaluationController::class, 'review'])->name('evaluation.review');
    Route::post('/committee/evaluation/review/{schedule_id}/submit', [EvaluationController::class, 'submitReview'])->name('evaluation.review.submit');
    Route::post('/evaluation/criteria/submit', [EvaluationCriteriaRatingController::class, 'store'])->name('evaluation.criteria.submit');
    
    // Owner 
    // Links
    Route::view('/dashboard', 'owner.dashboard')->name('owner.dashboard');
    Route::view('/inspection', 'owner.dashboard')->name('owner.inspection');
    Route::view('/account', 'owner.account')->name('owner.account');
    Route::view('/security', 'owner.security')->name('owner.security');
    Route::view('/monitoring', 'owner.monitoring')->name('owner.monitoring');

    // 
    // Dormitory Module
    Route::get('dormitories', [DormitoryController::class, 'index'])->name('dormitories.index');
    Route::get('dormitories/{id}', [DormitoryController::class, 'show'])->name('dormitories.show');

    // Evaluation Module
    Route::get('/evaluation', [EvaluationController::class, 'index'])->name('evaluation.index');
    Route::get('/evaluation/{id}', [EvaluationController::class, 'show'])->name('evaluation.show');
    Route::get('/committee/evaluation', [EvaluationController::class, 'showEvaluationSchedules'])->name('evaluation.schedules');
    Route::get('/committee/evaluation/form', [EvaluationController::class, 'showForm'])->name('evaluation.form');

    // Logout Route
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
