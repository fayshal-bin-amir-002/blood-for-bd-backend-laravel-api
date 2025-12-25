<?php

namespace App\Policies\V1;

use App\Enum\Role;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserPolicy
{

  public function isAdmin(User $user): bool
  {
    return $user->role->value === Role::ADMIN->value;
  }

  public function isOwnerOrAdmin(User $user, User $model): bool
  {
    return $user->role->value === Role::ADMIN->value || $user->id === $model->id;
  }

}
