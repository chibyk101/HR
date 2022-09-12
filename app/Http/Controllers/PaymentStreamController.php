<?php

namespace App\Http\Controllers;

use App\Models\PaymentStream;
use App\Http\Requests\StorePaymentStreamRequest;
use App\Http\Requests\UpdatePaymentStreamRequest;
use App\Models\SalaryItem;
use Illuminate\Support\Facades\Redirect;

class PaymentStreamController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('payment-streams.index', [
      'paymentStreams' => PaymentStream::all()
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('payment-streams.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \App\Http\Requests\StorePaymentStreamRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StorePaymentStreamRequest $request)
  {
    if(PaymentStream::whereNull('processed_at')->exists()){
      return back()->with('error','Active stream already exist');
    }
    $paymentStream = new PaymentStream($request->validated());
    $paymentStream->save();
    if($request->filled('salary_items')){
      $paymentStream->salaryItems()->attach($request->collect('salary_items'));
    }
    return Redirect::route('paymentStreams.index');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\PaymentStream  $paymentStream
   * @return \Illuminate\Http\Response
   */
  public function show(PaymentStream $paymentStream)
  {
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\PaymentStream  $paymentStream
   * @return \Illuminate\Http\Response
   */
  public function edit(PaymentStream $paymentStream)
  {
    if ($paymentStream->processed) {
      return back()->with('error', 'batch expired');
    }
    return view('payment-streams.edit', [
      'paymentStream' => $paymentStream->load('salaryItems'),
      'salaryItems' => SalaryItem::all(['id','name'])
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \App\Http\Requests\UpdatePaymentStreamRequest  $request
   * @param  \App\Models\PaymentStream  $paymentStream
   * @return \Illuminate\Http\Response
   */
  public function update(UpdatePaymentStreamRequest $request, PaymentStream $paymentStream)
  {
    if ($paymentStream->processed) {
      return back()->with('error', 'batch expired');
    }
    $paymentStream->fill($request->validated());
    $paymentStream->process_deductions = $request->filled('process_deductions');
    $paymentStream->include_basic_salary = $request->filled('include_basic_salary');
    $paymentStream->include_overtime = $request->filled('include_overtime');
    $paymentStream->save();
    if($request->filled('salary_items')){
      $paymentStream->salaryItems()->sync($request->collect('salary_items'));
    }
    return back()->with('success', 'Stream Updated');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\PaymentStream  $paymentStream
   * @return \Illuminate\Http\Response
   */
  public function destroy(PaymentStream $paymentStream)
  {
    if($paymentStream->processed_at?->isPast()){
      return back()->with('error',"can not delete processed stream");
    }
    $paymentStream->delete();
    return back();
  }

  public function markAsProcessed(PaymentStream $paymentStream)
  {
    $paymentStream->processed_at = now();
    $paymentStream->save();
    return back()->with('success','stream closed');
  }
}
