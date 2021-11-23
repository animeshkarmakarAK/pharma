<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'admin/smef-management', 'as' => 'smef_management::admin.', 'middleware' => ['auth']], function () {
    Route::resources([
        'test-url' => Module\SmefManagement\App\Http\Controllers\SmefTestController::class,
    ]);
    Route::get('test-url/{id}', [Module\SmefManagement\App\Http\Controllers\TestController::class, 'test-url.id'])
        ->name('test-url.id');

});


Route::group(['prefix' => 'smef-management', 'as' => 'smef_management::'], function () {
    Route::get('registration-form', [Module\SmefManagement\App\Http\Controllers\Frontend\SmefRegistrationController::class, 'index'])->name('registration-form');
});
