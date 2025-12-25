<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\DonorController;
use App\Http\Controllers\Api\V1\UserController;

use Illuminate\Support\Facades\Route;

Route::middleware('throttle:login_reg')->group(function() {

  Route::post("/register", [AuthController::class, 'register']);

  Route::post("/login", [AuthController::class, 'login']);

  Route::post("/logout", [AuthController::class, 'logout'])->middleware('auth:sanctum');

});

Route::middleware(['auth:sanctum'])->group(function() {
  Route::apiResource('/user', UserController::class)
    ->except(['store']);

  Route::apiResource('/donor', DonorController::class)
    ->only(['update', 'delete']);
});

Route::apiResource('/donor', DonorController::class)
    ->except(['update', 'delete']);