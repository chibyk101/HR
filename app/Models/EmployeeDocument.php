<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeDocument extends Model
{
    use HasFactory;

    protected $fillable = [
      'document',
      'user_id',
      'document_id'
    ];

    public function document()
    {
      return $this->belongsTo(Document::class);
    }

    public function user()
    {
      return $this->belongsTo(User::class);
    }
}
