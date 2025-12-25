<?php

namespace App\Models;

use App\Enum\BloodGroup;
use App\Traits\ApiQueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Donor extends Model
{
  use ApiQueryBuilder;
  
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
      'last_donation_date' => 'date',
      'blood_group' => BloodGroup::class,
      'is_active' => 'boolean'
    ];
  }

  public function user(): BelongsTo {
    return $this->belongsTo(User::class);
  }
}
