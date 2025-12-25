<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\DonorRequest;
use App\Http\Resources\V1\DonorResource;
use App\Models\Donor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DonorController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    Gate::authorize('isAdmin', User::class);

    $donors = Donor::with('user')->apiQuery($request);
    $res = DonorResource::collection($donors)->response()->getData(true);

    return ApiResponse::success('Retrived all donors', 200, $res);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(DonorRequest $request)
  {
    $validated = $request->validated();

    $user = auth('sanctum')->user();

    if($user) {
      $validated['user_id'] = $user->id;
    }

    $donor = Donor::create($validated);

    return ApiResponse::success('Donor created', 201, new DonorResource($donor));
  }

  /**
   * Display the specified resource.
   */
  public function show(Donor $donor)
  {
    Gate::authorize('isOwnerOrAdmin', $donor);
    $donor->load('user');
    return ApiResponse::success('Donor data retrived', 200, new DonorResource($donor));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(DonorRequest $request, Donor $donor)
  {
    Gate::authorize('isOwnerOrAdmin', $donor);
    $donor->update($request->validated());
    return ApiResponse::success('Donor data updated', 200, new DonorResource($donor));
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Donor $donor)
  {
    Gate::authorize('isOwnerOrAdmin', $donor);
    $donor->delete();
    return ApiResponse::success('Donor data deleted', 200);
  }
}
