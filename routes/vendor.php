<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {
    Route::post('loc-divisions/datatable', [App\Http\Controllers\GeoLocations\LocDivisionController::class, 'getDatatable'])->name('loc-divisions.datatable');
    Route::post('loc-districts/datatable', [App\Http\Controllers\GeoLocations\LocDistrictController::class, 'getDatatable'])->name('loc-districts.datatable');
    Route::post('loc-upazilas/datatable', [App\Http\Controllers\GeoLocations\LocUpazilaController::class, 'getDatatable'])->name('loc-upazilas.datatable');
    Route::resources([
        'loc-divisions' => App\Http\Controllers\GeoLocations\LocDivisionController::class,
        'loc-districts' => App\Http\Controllers\GeoLocations\LocDistrictController::class,
        'loc-upazilas' => App\Http\Controllers\GeoLocations\LocUpazilaController::class
    ]);

    //    Route::get('/profile', [App\Http\Controllers\Admin\UserController::class, 'profile'])->name('admin-profile');
    Route::resource('/users', App\Http\Controllers\Admin\UserController::class);
    Route::get('/users/{user}/trainers', [App\Http\Controllers\Admin\UserController::class, 'trainers'])->name('users.trainers');
    Route::resource('user-types', App\Http\Controllers\UserTypeController::class)
        ->except(['create', 'store', 'destroy']);

    Route::post('/users/datatable', [App\Http\Controllers\Admin\UserController::class, 'getDatatable'])->name('users.datatable');
    Route::post('/users/{user}/roles', [App\Http\Controllers\Admin\UserController::class, 'userRoleSync'])->name('users.role-sync');
    Route::get('/users/{user}/permissions', [App\Http\Controllers\Admin\UserController::class, 'userPermissionIndex'])->name('users.permissions');
    Route::post('/users/{user}/permissions', [App\Http\Controllers\Admin\UserController::class, 'userPermissionSync'])->name('users.permission-sync');
    Route::get('/check-user-email', [\App\Http\Controllers\Admin\UserController::class, 'checkUserEmail'])->name('check-user-email');

    Route::get('roles/{role}/permissions', [App\Http\Controllers\RoleController::class, 'rolePermissionIndex'])->name('roles.permissions');
    Route::post('roles/{role}/permissions', [App\Http\Controllers\RoleController::class, 'rolePermissionSync'])->name('roles.permission-sync');
    Route::post('roles/datatable', [App\Http\Controllers\RoleController::class, 'getDatatable'])->name('roles.datatable');
    Route::post('permissions/datatable', [App\Http\Controllers\PermissionController::class, 'getDatatable'])->name('permissions.datatable');

    Route::resources([
        'roles' => App\Http\Controllers\RoleController::class,
        'permissions' => App\Http\Controllers\PermissionController::class
    ]);

    Route::get('row-status', [App\Http\Controllers\RowStatusController::class, 'index'])->name('row-status');

    //themes
    Route::resource('/themes', App\Http\Controllers\ThemesController::class);
    Route::post('themes/datatable', [App\Http\Controllers\ThemesController::class, 'getDatatable'])->name('themes.datatable');
    Route::get('change-themes', [App\Http\Controllers\ThemesController::class, 'changeThemeList'])->name('themes.changeThemeList');
    Route::post('apply-theme', [App\Http\Controllers\ThemesController::class, 'applyTheme'])->name('themes.applyTheme');

});

Route::group(['middleware' => ['auth']], function () {
    Route::post('/admin/typeahead/search', [App\Http\Controllers\UtilityAPI\TypeaheadAPI::class, 'index'])->name('admin.typeahead.search');
});

Route::group(['middleware' => ['web']], function () {
    Route::get('/admin/login/{redirect?}', [App\Http\Controllers\Admin\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::get('/admin/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'showLoginForm'])->name('admin.login-form');
    Route::post('/admin/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'login'])->name('admin.login');
    Route::post('/admin/logout', [App\Http\Controllers\Admin\Auth\LoginController::class, 'logout'])->name('admin.logout');
    Route::get('/admin/register', [App\Http\Controllers\Admin\Auth\RegisterController::class, 'showRegistrationForm'])->name('admin.register-form');
    Route::post('/admin/register', [App\Http\Controllers\Admin\Auth\RegisterController::class, 'register'])->name('admin.register');
    Route::get('/admin/forgot', [App\Http\Controllers\Admin\Auth\ForgotPasswordController::class, 'showForgotPasswordForm'])->name('admin.forgot-password-form');
});

Route::group(['prefix' => 'web-api', 'as' => 'web-api.'], function () {
    Route::post('model-resources', [\App\Http\Controllers\UtilityAPI\ModelResourceFetchController::class, 'modelResources'])
        ->name('model-resources');
});

/** Change Language > options > Bangla|English */
Route::post('change-language/{language}', [\App\Http\Controllers\Admin\LocalizationController::class, 'changeLanguage'])->name('change-language');
