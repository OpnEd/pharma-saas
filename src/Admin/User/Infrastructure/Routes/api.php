<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Src\Admin\User\Infrastructure\Controllers\CreateUserPOSTController;
use Src\Admin\User\Infrastructure\Controllers\GetUserByIdGETController;

// Simpele route example
Route::get('/{id}', [GetUserByIdGETController::class, 'index']);
Route::post('/', [CreateUserPOSTController::class, 'index']);

//Authenticathed route example
// Route::middleware(['auth:sanctum','activitylog'])->get('/', [GetUserByIdGETController::class, 'index']);
