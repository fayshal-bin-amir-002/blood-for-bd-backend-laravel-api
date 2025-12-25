<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Requests\V1\DonorRequest;
use App\Http\Resources\V1\DonorResource;
use App\Models\Donor;
use Illuminate\Http\Request;

class DonorController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
      //
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
      //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Donor $donor)
  {
      //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Donor $donor)
  {
      //
  }
}
