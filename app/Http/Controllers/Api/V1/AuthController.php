<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
  public function register(Request $request) {

    $validated = $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'email', 'unique:users'],
      'password' => ['required', 'min:6', 'confirmed']
    ]);

    $user = User::create($validated);
    $token = $user->createToken('access_token')->plainTextToken;

    $data = [
      'user' => $user,
      'token' => $token
    ];
    

    return ApiResponse::success('Registration Successfully', 201, $data);
  }

  public function login(Request $request) {

    $request->validate([
      'email' => ['required', 'email'],
      'password' => ['required']
    ]);

    $user = User::where('email', $request->email)->first();

    if(!$user || !Hash::check($request->password, $user->password)) {
      return ApiResponse::error('Invalid credentials', 401);
    }

    $token = $user->createToken('access_token')->plainTextToken;

    $data = [
      'token' => $token
    ];
    

    return ApiResponse::success('Logged in Successfully', 200, $data);
  }
}
