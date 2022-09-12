<?php

namespace App\Models;

use App\Observers\OvertimeObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'name', 
    'rate',
    'number_of_days',
    'hours'
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  static function booted()
  {
    static::observe(new OvertimeObserver);
  }
}
