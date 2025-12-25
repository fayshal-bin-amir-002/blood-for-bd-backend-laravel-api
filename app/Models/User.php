<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enum\Role;
use App\Notifications\ResetPasswordNotification;
use App\Traits\ApiQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
  /** @use HasFactory<\Database\Factories\UserFactory> */
  use HasFactory, Notifiable, HasApiTokens, ApiQueryBuilder;

  /**
   * The attributes that are mass assignable.
   *
   * @var list<string>
   */
  protected $fillable = [
      'name',
      'email',
      'password',
      'role',
      'is_blocked'
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var list<string>
   */
  protected $hidden = [
      'password',
      'remember_token',
  ];

  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => Role::class,
        'is_blocked' => 'boolean'
    ];
  }

  public function sendPasswordResetNotification($token): void
  {
    $url = 'http://localhost:3000/reset-password?token=' . $token . '&email=' . $this->email;

    $this->notify(new ResetPasswordNotification($url));
  }

  public function donor(): HasOne {
    return $this->hasOne(Donor::class);
  }
}
