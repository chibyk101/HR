<?php

namespace App\Services;

use App\Models\PaymentStream;
use App\Models\Payslip;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class PaymentService
{

  public function getStreams(string $month)
  {
    return PaymentStream::with('salaryItems')->where('payment_month', $month)->get();
  }

  public function generatePayslips(array $paymentData, PaymentStream $paymentStream)
  {
    $users = new Collection();
    switch ($paymentData['paying_by']) {
      case 'department':
        $users = User::query()->whereHas('departments', function ($query) use ($paymentData) {
          $query->where('department_user.department_id', $paymentData['paying_id']);
        })->whereDoesntHave('payslips', function ($query) use ($paymentData, $paymentStream) {
          $query->where('payment_stream_id', $paymentStream->id)->where('paying_id', $paymentData['paying_id']);
        })->get();
        break;
      case 'branch':
        $users = User::query()->where('branch_id', $paymentData['paying_id'])
          ->whereDoesntHave('payslips', function ($query) use ($paymentData, $paymentStream) {
            $query->where('payment_stream_id', $paymentStream->id)->where('paying_id', $paymentData['paying_id']);
          })->get();
        break;
      case 'designation':
        $users = User::query()->where('designation_id', $paymentData['paying_id'])
          ->whereDoesntHave('payslips', function ($query) use ($paymentData, $paymentStream) {
            $query->where('payment_stream_id', $paymentStream->id)->where('paying_id', $paymentData['paying_id']);
          })->get();
        break;
      default:
        $users = User::query()->where('office_type_id', $paymentData['paying_id'])
          ->whereDoesntHave('payslips', function ($query) use ($paymentData, $paymentStream) {
            $query->where('payment_stream_id', $paymentStream->id)->where('paying_id', $paymentData['paying_id']);
          })->get();
        break;
    }

    /**
     * @var User[] $users
     */
    foreach ($users as $user) {
      $payslip = new Payslip($paymentData);
      $payslip->paymentStream()->associate($paymentStream);
      $payslip->user()->associate($user);

      //include overtimes if it is allowed by paying stream
      $overtimes = $paymentStream->include_overtime ?  $user->overtimes()->sum('total') : 0;

      //include basic salary if it is allowed by paying stream
      $basic_salary = $paymentStream->include_basic_salary ? $user->basic_salary : 0;
      //salary items included in payment stream
      $gross = $basic_salary + $user->salaryItems()->wherePivotIn('salary_item_id', $paymentStream->salaryItems()->allRelatedIds())->sum('salary_item_user.amount') + $overtimes;
      //check if stream processes deductions before adding them
      $deductions = $paymentStream->getAttribute('process_deductions') ? $user->deductions()->sum('amount') : 0;
      $net = $gross - $deductions;
      $payslip->gross_payable = $gross;
      $payslip->net_payable = $net;
      $payslip->salary_month = $paymentStream->getAttribute('payment_month');
      $payslip->save();
    }
  }
  /**
   * regenerate payslip for user
   */
  public function regeneratePayslip(User $user)
  {
    $user->load('payslips.paymentStream');
    foreach ($user->payslips()
      ->getQuery()
      ->where('paid_at', null)
      ->whereHas('PaymentStream', function ($query) {
        $query->where(
          [
            'payment_month' => now()->format('Y-m'),
            'processed_at' => null
          ]
        );
      })->get() as $payslip) {
      $paymentStream = $payslip->paymentStream;
      //include overtimes if it is allowed by paying stream
      $overtimes = $paymentStream->include_overtime ?  $user->overtimes()->sum('total') : 0;

      //include basic salary if it is allowed by paying stream
      $basic_salary = $paymentStream->include_basic_salary ? $user->basic_salary : 0;
      //salary items included in payment stream
      $gross = $basic_salary + $user->salaryItems()->wherePivotIn('salary_item_id', $paymentStream->salaryItems()->allRelatedIds())->sum('salary_item_user.amount') + $overtimes;
      //check if stream processes deductions before adding them
      $deductions = $paymentStream->getAttribute('process_deductions') ? $user->deductions()->sum('amount') : 0;
      $net = $gross - $deductions;
      $payslip->gross_payable = $gross;
      $payslip->net_payable = $net;
      $payslip->salary_month = $paymentStream->getAttribute('payment_month');
      $payslip->save();
    }
  }
}
