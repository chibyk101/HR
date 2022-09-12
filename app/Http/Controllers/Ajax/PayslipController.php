<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Payslip;
use App\Http\Requests\StorePayslipRequest;
use App\Models\PaymentStream;

class PayslipController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(PaymentStream $paymentStream)
  {
    return [
      'payslips' => $paymentStream->payslips()->getQuery()->when(request('paying_id') && request('paying_by'), function ($query) {
        $query->where(['paying_id' => request('paying_id'), 'paying_by' => request('paying_by')]);
      })->with('user')->paginate(),
    ];
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \App\Http\Requests\StorePayslipRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StorePayslipRequest $request)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Payslip  $payslip
   * @return \Illuminate\Http\Response
   */
  public function destroy(Payslip $payslip)
  {
    //
  }
}
