<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDeductionRequest;
use App\Models\Deduction;
use Illuminate\Http\Request;

class DeductionController extends Controller
{

  public function search(Request $request)
  {
    $deductions = Deduction::query()
      ->whereHas('user', function ($query) use ($request) {
        $query->where('is_admin', false)
          ->where('first_name', 'like', "%{$request->query('q')}%")
          ->orWhere('last_name', 'like', "%{$request->query('q')}%")
          ->orWhere('email', 'like', "%{$request->query('q')}%")
          ->orWhere('phone', 'like', "%{$request->query('q')}%")
          ->orWhere('staff_id', 'like', "%{$request->query('q')}%");
      })
      ->orWhere('name', 'like', "%{$request->query('q')}%")
      ->get(['id', 'first_name', 'last_name'])->map(fn ($item) => ['id' => $item->id,'text' => $item->name]);
    return $deductions->toArray();
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    return [
      'deductions' => Deduction::with('user')->withoutGlobalScope('is_active_deduction')
      ->when($request->query('q'),function($q) use ($request){
        $q->whereHas('user', function ($query) use ($request) {
          $query->where('is_admin', false)
            ->where('first_name', 'like', "%{$request->query('q')}%")
            ->orWhere('last_name', 'like', "%{$request->query('q')}%")
            ->orWhere('email', 'like', "%{$request->query('q')}%")
            ->orWhere('phone', 'like', "%{$request->query('q')}%")
            ->orWhere('staff_id', 'like', "%{$request->query('q')}%");
        })
        ->orWhere('name', 'like', "%{$request->query('q')}%");
      })
      ->latest()->paginate()
    ];
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \App\Http\Requests\StoreDeductionRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreDeductionRequest $request)
  {
    foreach ($request->collect('users') as $user) {
      $deduction = new Deduction($request->validated());
      if (Deduction::query()->withoutGlobalScope('is_active_deduction')->where(['user_id' => $request->user_id, 'name' => $request->name])->exists() == false) {
        $deduction->user()->associate($user);
        $deduction->save();
      }
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Deduction  $deduction
   * @return \Illuminate\Http\Response
   */
  public function destroy(Deduction $deduction)
  {
    $deduction->delete();
  }
}
