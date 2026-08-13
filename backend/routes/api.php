<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\PermissionController;
use App\Http\Controllers\Api\V1\ProgramController;
use App\Http\Controllers\Api\V1\RoleController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('v1.')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');

    // Público: vitrine de empreendimentos exibida no front-end, sem autenticação.
    Route::get('programs', [ProgramController::class, 'index'])->name('programs.index');
    Route::get('programs/{program}', [ProgramController::class, 'show'])->name('programs.show');

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('me', [AuthController::class, 'me'])->name('me');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');

        Route::apiResource('users', UserController::class);
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);
        Route::apiResource('programs', ProgramController::class)->except(['index', 'show']);
    });
});
