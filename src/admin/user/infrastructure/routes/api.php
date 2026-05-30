<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Src\admin\user\infrastructure\controllers\CreateUserPOSTController;
use Src\admin\user\infrastructure\controllers\GetUserByIdGETController;

// Simpele route example
Route::get('/{id}', [GetUserByIdGETController::class, 'index']);
Route::post('/', [CreateUserPOSTController::class, 'index']);

//Authenticathed route example
// Route::middleware(['auth:sanctum','activitylog'])->get('/', [GetUserByIdGETController::class, 'index']);
