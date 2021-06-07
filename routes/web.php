<?php

use Illuminate\Support\Facades\Route;


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('/');
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {
    Route::get('row-status', [App\Http\Controllers\RowStatusController::class, 'index'])->name('row-status');

    Route::resources([
        'organization-types' => App\Http\Controllers\OrganizationTypeController::class,
        'organizations' => App\Http\Controllers\OrganizationController::class,
        'rank-types' => App\Http\Controllers\RankTypeController::class,
        'ranks' => App\Http\Controllers\RankController::class,
        'skills' => App\Http\Controllers\SkillController::class,
        'services' => App\Http\Controllers\ServiceController::class,

        ]);

    Route::post('rank-types/datatable', [App\Http\Controllers\RankTypeController::class, 'getDatatable'])->name('rank-types.datatable');
    Route::post('ranks/datatable', [App\Http\Controllers\RankController::class, 'getDatatable'])->name('ranks.datatable');
    Route::post('skills/datatable', [App\Http\Controllers\SkillController::class, 'getDatatable'])->name('skills.datatable');
    Route::post('services/datatable', [App\Http\Controllers\ServiceController::class, 'getDatatable'])->name('services.datatable');
    Route::post('organization-types/datatable', [App\Http\Controllers\OrganizationTypeController::class, 'getDatatable'])->name('organization-types.datatable');
    Route::post('organizations/datatable', [App\Http\Controllers\OrganizationController::class, 'getDatatable'])->name('organizations.datatable');

});

Route::group(['prefix' => 'web-api', 'as' => 'web-api.'], function () {
    Route::post('model-resources', [\App\Http\Controllers\WebAPI\FrontEndController::class, 'modelResources'])
        ->name('model-resources');
});



