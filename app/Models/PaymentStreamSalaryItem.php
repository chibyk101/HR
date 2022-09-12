<?php

namespace App\Models;

use App\Services\PaymentService;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PaymentStreamSalaryItem extends Pivot
{

  protected $fillable = [
    'salary_item_id',
    'payment_stream_id'
  ];
  public function salaryItem()
  {
    return $this->belongsTo(SalaryItem::class, 'salary_item_id');
  }
  static function booted()
  {
    static::saved(function (self $paymentStreamSalaryItem) {
      foreach ($paymentStreamSalaryItem->salaryItem->users as $user) {
        (new PaymentService)->regeneratePayslip($user);
      }
    });
    static::deleted(function (self $paymentStreamSalaryItem) {
      foreach ($paymentStreamSalaryItem->salaryItem->users as $user) {
        (new PaymentService)->regeneratePayslip($user);
      }
    });
  }
}
