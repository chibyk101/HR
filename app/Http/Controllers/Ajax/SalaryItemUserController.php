<?php

namespace App\Http\Controllers\Ajax;

use App\Models\SalaryItem;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SalaryItemUserController extends Controller
{

  public function store(Request $request, SalaryItem $salaryItem, User $user)
  {
    $salaryItem->users()->attach($user, [
      'amount' => $request->amount
    ]);
  }


  public function update(Request $request, SalaryItem $salaryItem, User $user)
  {
    $salaryItem->users()->updateExistingPivot($user, [
      'amount' => $request->amount
    ]);
  }

  public function destroy(SalaryItem $salaryItem, User $user)
  {
    $salaryItem->users()->detach($user);
   
  }

}
