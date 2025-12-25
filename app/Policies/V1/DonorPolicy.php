<?php

namespace App\Policies\V1;

use App\Enum\Role;
use App\Models\Donor;
use App\Models\User;

class DonorPolicy
{
  /**
   * Determine whether the user can view any models.
   */
  public function isAdmin(User $user): bool
  {
    return $user->role->value === Role::ADMIN->value;
  }

  public function isOwnerOrAdmin(User $user, Donor $donor): bool
  {
    return $user->role->value === Role::ADMIN->value || $user->id === $donor->user_id;
  }

}
