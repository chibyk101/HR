<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\SalaryItem;
use Illuminate\Http\Request;

class SalaryItemController extends Controller
{
  public function show(SalaryItem $salaryItem)
  {
    return response()->json([
      'salaryItem' => $salaryItem,
      'users' => $salaryItem->users()->latest()->paginate()
    ]);
  }

  public function search(Request $request)
  {
    return SalaryItem::where('name', 'like', "%{$request->query('q')}%")
      ->limit(10)
      ->get()
      ->map(
        fn ($item) =>
        [
          'id' => $item->id,
          'text' => $item->name
        ]
      );
  }
}
