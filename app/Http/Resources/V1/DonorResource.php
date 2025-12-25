<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DonorResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return [
      'id' => $this->id,
      'name' => $this->name,
      'contact' => $this->contact,
      'division' => $this->division,
      'district' => $this->district,
      'sub_district' => $this->sub_district,
      'address' => $this->address,
      'blood_group' => $this->blood_group,
      'last_donation_date' => $this->last_donation_date->format('d M, Y'),
      'is_active' => $this->is_active,
      'user' => new UserResource($this->whenLoaded('user'))
    ];
  }
}
