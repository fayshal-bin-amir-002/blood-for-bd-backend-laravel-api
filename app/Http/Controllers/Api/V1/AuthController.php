<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

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

  public function logout(Request $request) {
    $request->user()->currentAccessToken()->delete();
    return ApiResponse::success('Logged out Successfully', 200);
  }

  public function forgotPassword(Request $request) {
    $request->validate([
      'email' => ['required', 'email'],
    ]);

    $status = Password::broker()->sendResetLink(
      $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
      ? ApiResponse::success('Reset link sent to your email.')
      : ApiResponse::error('Unable to send reset link.', 400);

  }

  public function resetPassword(Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:6|confirmed',
    ]);
 
    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));
 
            $user->save();
 
            event(new PasswordReset($user));
        }
    );

    return $status === Password::PASSWORD_RESET
      ? ApiResponse::success('Password has been reset.')
      : ApiResponse::error(__($status), 400);
  }
  
}
