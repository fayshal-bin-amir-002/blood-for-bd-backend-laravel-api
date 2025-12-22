<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{

  public function register(Request $request) {
    
    $validated = $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'email', 'unique:users'],
      'password' => ['required', 'min:6', 'confirmed']
    ]);

    return ApiResponse::success('Registration Successfully', 201, $validated);
  }
}
