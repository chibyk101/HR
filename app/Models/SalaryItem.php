<?php

namespace App\Models;

use App\Observers\SalaryItemObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryItem extends Model
{
    use HasFactory;
    protected $fillable = [
      'name','is_active'
    ];

    public function users()
    {
      return $this->belongsToMany(User::class)->using(SalaryItemUser::class)->withPivot('amount');
    }

    public function paymentStreams()
    {
      return $this->belongsToMany(PaymentStream::class)->using(PaymentStreamSalaryItem::class);
    }
}
