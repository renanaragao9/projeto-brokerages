<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ConstructionUpdateController;
use App\Http\Controllers\Api\V1\NoticeController;
use App\Http\Controllers\Api\V1\PermissionController;
use App\Http\Controllers\Api\V1\PropertyController;
use App\Http\Controllers\Api\V1\RoleController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('v1.')->group(function () {
    Route::post('login', [AuthController::class, 'login'])
        ->middleware('throttle:login')
        ->name('login');

    Route::middleware('throttle:public-read')->group(function () {
        Route::get('properties', [PropertyController::class, 'index'])->name('properties.index');
        Route::get('properties/{property}', [PropertyController::class, 'show'])
            ->whereNumber('property')
            ->name('properties.show');

        Route::get('construction-updates', [ConstructionUpdateController::class, 'index'])->name('construction-updates.index');

        Route::get('notices', [NoticeController::class, 'index'])->name('notices.index');
        Route::get('notices/{slug}', [NoticeController::class, 'show'])
            ->where('slug', '[a-z0-9-]+')
            ->name('notices.show');
    });

    Route::middleware('throttle:public-write')->group(function () {
        Route::post('construction-updates', [ConstructionUpdateController::class, 'store'])->name('construction-updates.store');
    });

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('me', [AuthController::class, 'me'])->name('me');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');

        Route::apiResource('users', UserController::class);
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);
    });
});
