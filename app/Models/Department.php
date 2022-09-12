<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $fillable = [
      'name',
      'subsidiary_id',
    ];

    public function subsidiary()
    {
      return $this->belongsTo(Subsidiary::class);
    }

    public function branches()
    {
      return $this->hasMany(Branch::class);
    }
}
