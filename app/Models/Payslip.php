<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payslip extends Model
{
    use HasFactory;
    
    protected $fillable = [
      'user_id',
      'salary_month',
      'net_payable',
      'gross_payable',
      'paid_at',
      'payment_stream_id',
      'paying_by',
      'paying_id'
    ];

    protected $dates = [
      'paid_at'
    ];

    /**
     * owner of this payslip
     */

    public function user()
    {
      return $this->belongsTo(User::class);
    }

    public function paymentStream()
    {
      return $this->belongsTo(PaymentStream::class);
    }
   
}
