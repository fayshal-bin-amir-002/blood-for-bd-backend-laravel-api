<?php

use App\Http\Controllers\Api\V1\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:login_reg')->group(function() {

  Route::post("/register", [AuthController::class, 'register']);

  Route::post("/login", [AuthController::class, 'login']);

});




Route::prefix('v1')->group(base_path('routes/Api/v1.php'));