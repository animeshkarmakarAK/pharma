<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {
    Route::get('/', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('admin-dashboard');

    Route::post('loc-divisions/datatable', [App\Http\Controllers\GeoLocations\LocDivisionController::class, 'getDatatable'])->name('loc-divisions.datatable');
    Route::post('loc-districts/datatable', [App\Http\Controllers\GeoLocations\LocDistrictController::class, 'getDatatable'])->name('loc-districts.datatable');
    Route::post('loc-upazilas/datatable', [App\Http\Controllers\GeoLocations\LocUpazilaController::class, 'getDatatable'])->name('loc-upazilas.datatable');

    Route::resources([
        'loc-divisions' => App\Http\Controllers\GeoLocations\LocDivisionController::class,
        'loc-districts' => App\Http\Controllers\GeoLocations\LocDistrictController::class,
        'loc-upazilas' => App\Http\Controllers\GeoLocations\LocUpazilaController::class
    ]);
});

Route::group(['middleware' => ['auth']], function () {
    Route::post('/admin/typeahead/search', [App\Http\Controllers\Admin\UtilityAPI\TypeaheadAPI::class, 'index'])->name('admin.typeahead.search');
});
