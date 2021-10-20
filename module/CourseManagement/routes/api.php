<?php


use Illuminate\Support\Facades\Route;

Route::post('ipn-handler', [Module\CourseManagement\App\Http\Controllers\Frontend\YouthController::class, 'ipnHandler'])->name('api-ipn-handler');
//Route::post('youth-bulk-import', [Module\CourseManagement\App\Http\Controllers\YouthManagementController::class, 'importYouth'])->name('api-youth-bulk-import');



