<?php

namespace App\Http\Controllers\Api\V1;

use App\Enum\Role;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;


class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {

    Gate::authorize('isAdmin', User::class);

    $users = User::apiQuery($request, ['name', 'email']);
    $res = UserResource::collection($users)->response()->getData(true);

    return ApiResponse::success('Retrived all users', 200, $res);
  }


  /**
   * Display the specified resource.
   */
  public function show(User $user)
  {
    Gate::authorize('isOwnerOrAdmin', $user);
    return ApiResponse::success('Retrived user', 200, new UserResource($user));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, User $user)
  {
    Gate::authorize('isAdmin', User::class);
    $validated = $request->validate([
      'is_blocked' => ['required', 'boolean'],
      'role' => ['required', Rule::enum(Role::class)]
    ]);
    $user->update($validated);
    return ApiResponse::success('User updated successfully', 200, new UserResource($user));
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(User $user)
  {
    Gate::authorize('isAdmin', User::class);
    $user->delete();
    return ApiResponse::success('User deleted successfully');
  }
}
