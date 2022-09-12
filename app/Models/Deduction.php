<?php

namespace App\Models;

use App\Observers\DeductionObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deduction extends Model
{
  use HasFactory;
  protected $fillable = [
    'name',
    'amount',
    'user_id',
    'is_active'
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  static function booted()
  {
    static::observe(DeductionObserver::class);
    static::addGlobalScope('is_active_deduction', function (Builder $builder) {
      $builder->where('is_active', true);
    });
  }

  public function resolveRouteBinding($value, $field = null)
  {
    return $this->query()->withoutGlobalScope('is_active_deduction')->where('id', $value)->firstOrFail();
  }
  
}
