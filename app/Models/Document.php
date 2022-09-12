<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $fillable = [
      'name',
      'is_required'
    ];


    public function employeeDocuments()
    {
      return $this->hasMany(EmployeeDocument::class);
    }
    
}
