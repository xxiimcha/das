<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {return view('landing');});
// Route for Dormitories List
Route::get('/dormitories', function () {return view('dormitories');});
