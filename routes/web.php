<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\Module\CourseManagement\App\Http\Controllers\HomeController::class, 'index'])->name('/');

Route::get('/organization-information',[\Module\GovtStakeholder\App\Http\Controllers\OrganizationInformationController::class,'organizationInformation'])->name('organization-information');
Route::post('organization-information/datatable',[\Module\GovtStakeholder\App\Http\Controllers\OrganizationInformationController::class, 'getOrganizationInformation'])->name('organization-information.datatable');
Route::get('/organization-information/create',[\Module\GovtStakeholder\App\Http\Controllers\OrganizationInformationController::class,'organizationInformationCreate'])->name('organization-information.create');
Route::post('/organization-information/store',[\Module\GovtStakeholder\App\Http\Controllers\OrganizationInformationController::class,'organizationInformationStore'])->name('organization-information.store');



Route::get('/success', [\Module\CourseManagement\App\Http\Controllers\HomeController::class, 'success'])->name('success');
Route::get('/fail', [\Module\CourseManagement\App\Http\Controllers\HomeController::class, 'fail'])->name('fail');
Route::get('/cancel', [\Module\CourseManagement\App\Http\Controllers\HomeController::class, 'cancel'])->name('cancel');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {
    Route::get('/', [\Module\GovtStakeholder\App\Http\Controllers\DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard', [\Module\GovtStakeholder\App\Http\Controllers\DashboardController::class, 'dashboard'])->name('admin-dashboard');
    Route::post('/dashboard-upazila-job-statistic', [\Module\GovtStakeholder\App\Http\Controllers\DashboardController::class, 'dashboardUpazilaJobStatistic'])->name('admin-dashboard-upazila-job-statistic');

    Route::get('/check-unique-user-email', [App\Http\Controllers\Admin\UserController::class, 'checkUserEmailUniqueness'])->name('users.check-unique-user-email');

});


