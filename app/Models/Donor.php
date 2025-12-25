<?php

namespace App\Models;

use App\Enum\BloodGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Donor extends Model
{
  protected $fillable = [
    'user_id',
    'name',
    'contact',
    'division',
    'district',
    'sub_district',
    'address',
    'blood_group',
    'last_donation_date',
    'is_active',
  ];

  protected function casts()
  {
    return [
      'blood_group' => BloodGroup::class,
      'is_active' => 'boolean'
    ];
  }

  public function user(): BelongsTo {
    return $this->belongsTo(User::class);
  }
}
