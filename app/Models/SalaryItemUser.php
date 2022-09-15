<?php

namespace App\Models;

use App\Services\PaymentService;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SalaryItemUser extends Pivot
{
  protected $fillable = [
    'salary_item_id',
    'user_id',
    'amount'
  ];
    public function user()
    {
      return $this->belongsTo(User::class);
    }

    public function salaryItem()
    {
      return $this->belongsTo(SalaryItem::class,'salary_item_id');
    }

    static function booted()
    {
      static::saved(function(self $salaryItemUser){
        info('added and should update');
        (new PaymentService)->regeneratePayslip($salaryItemUser->user);
      });
      static::deleted(function(self $salaryItemUser){
        (new PaymentService)->regeneratePayslip($salaryItemUser->user);
      });
    }
}
