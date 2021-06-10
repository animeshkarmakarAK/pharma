<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\Module\CourseManagement\App\Http\Controllers\HomeController::class, 'index'])->name('/');
