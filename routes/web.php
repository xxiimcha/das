<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {return view('landing');});
// Route for Dormitories List
Route::get('/dormitories', function () {return view('dormitories');});

// Route for Login Page
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('dashboard');

