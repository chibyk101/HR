<?php

namespace App\Models;

use App\Observers\PaymentStreamObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentStream extends Model
{
    use HasFactory;

    protected $fillable = [
      'name',
      'process_deductions',
      'payment_month',
      'processed_at',
      'include_basic_salary',
      'include_overtime',
    ];

    protected $casts = [
      'process_deductions' => 'boolean',
      'include_basic_salary' => 'boolean',
      'include_overtime' => 'boolean',
    ];

    protected $dates = [
      'processed_at'
    ];


    public function salaryItems()
    {
      return $this->belongsToMany(SalaryItem::class)->using(PaymentStreamSalaryItem::class);
    }

    public function payslips()
    {
      return $this->hasMany(Payslip::class);
    }

    static function booted()
    {
      static::observe(PaymentStreamObserver::class);
    }
}
