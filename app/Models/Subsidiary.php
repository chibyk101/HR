<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subsidiary extends Model
{
    use HasFactory;

    protected $fillable = [
      'name'
    ];

    public function departments()
    {
      return $this->hasMany(Department::class);
    }

    public function branches()
    {
      return $this->hasManyThrough(Branch::class,Department::class);
    }
}
