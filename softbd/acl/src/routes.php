<?php

use \Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web']], function () {
    Route::get('/admin/login/{redirect?}', [Softbd\Acl\Controllers\Admin\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::get('/admin/login', [Softbd\Acl\Controllers\Admin\Auth\LoginController::class, 'showLoginForm'])->name('admin.login-form');
    Route::post('/admin/login', [Softbd\Acl\Controllers\Admin\Auth\LoginController::class, 'login'])->name('admin.login');
    Route::post('/admin/logout', [Softbd\Acl\Controllers\Admin\Auth\LoginController::class, 'logout'])->name('admin.logout');
    Route::get('/admin/register', [Softbd\Acl\Controllers\Admin\Auth\RegisterController::class, 'showRegistrationForm'])->name('admin.register-form');
    Route::post('/admin/register', [Softbd\Acl\Controllers\Admin\Auth\RegisterController::class, 'register'])->name('admin.register');
    Route::get('/admin/forgot', [Softbd\Acl\Controllers\Admin\Auth\ForgotPasswordController::class, 'showForgotPasswordForm'])->name('admin.forgot-password-form');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['web', 'auth']], function () {
//    Route::get('/profile', [Softbd\Acl\Controllers\Admin\UserController::class, 'profile'])->name('admin-profile');
    Route::resource('/users', Softbd\Acl\Controllers\Admin\UserController::class);
    Route::resource('user-types', Softbd\Acl\Controllers\UserTypeController::class)
        ->except(['create', 'store', 'destroy']);

    Route::post('/users/datatable', [Softbd\Acl\Controllers\Admin\UserController::class, 'getDatatable'])->name('users.datatable');
    Route::post('/users/{user}/roles', [Softbd\Acl\Controllers\Admin\UserController::class, 'userRoleSync'])->name('users.role-sync');
    Route::get('/users/{user}/permissions', [Softbd\Acl\Controllers\Admin\UserController::class, 'userPermissionIndex'])->name('users.permissions');
    Route::post('/users/{user}/permissions', [Softbd\Acl\Controllers\Admin\UserController::class, 'userPermissionSync'])->name('users.permission-sync');

    Route::get('roles/{role}/permissions', [Softbd\Acl\Controllers\RoleController::class, 'rolePermissionIndex'])->name('roles.permissions');
    Route::post('roles/{role}/permissions', [Softbd\Acl\Controllers\RoleController::class, 'rolePermissionSync'])->name('roles.permission-sync');
    Route::post('roles/datatable', [Softbd\Acl\Controllers\RoleController::class, 'getDatatable'])->name('roles.datatable');
    Route::post('permissions/datatable', [Softbd\Acl\Controllers\PermissionController::class, 'getDatatable'])->name('permissions.datatable');

    Route::resources([
        'roles' => Softbd\Acl\Controllers\RoleController::class,
        'permissions' => Softbd\Acl\Controllers\PermissionController::class
    ]);
});
