<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\Module\CourseManagement\App\Http\Controllers\HomeController::class, 'index'])->name('/');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {
    Route::get('/', [\Module\GovtStakeholder\App\Http\Controllers\DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard', [\Module\GovtStakeholder\App\Http\Controllers\DashboardController::class, 'dashboard'])->name('admin-dashboard');
});
