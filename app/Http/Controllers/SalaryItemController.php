<?php

namespace App\Http\Controllers;

use App\Exports\SampleExport;
use App\Models\SalaryItem;
use App\Http\Requests\StoreSalaryItemRequest;
use App\Http\Requests\UpdateSalaryItemRequest;
use App\Imports\SalaryItemImport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;

class SalaryItemController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('salary-items.index', [
      'salaryItems' => SalaryItem::all()
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('salary-items.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \App\Http\Requests\StoreSalaryItemRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreSalaryItemRequest $request)
  {
    $salaryItem = new SalaryItem($request->validated());
    $salaryItem->save();
    return Redirect::route('salaryItems.index')->with('success', 'Item added');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\SalaryItem  $salaryItem
   * @return \Illuminate\Http\Response
   */
  public function show(SalaryItem $salaryItem)
  {
    return view('salary-items.show', [
      'salaryItem' => $salaryItem
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\SalaryItem  $salaryItem
   * @return \Illuminate\Http\Response
   */
  public function edit(SalaryItem $salaryItem)
  {
    return view('salary-items.edit', compact('salaryItem'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \App\Http\Requests\UpdateSalaryItemRequest  $request
   * @param  \App\Models\SalaryItem  $salaryItem
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateSalaryItemRequest $request, SalaryItem $salaryItem)
  {
    $salaryItem->fill($request->validated());
    $salaryItem->save();
    return back()->with('success', 'Item updated');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\SalaryItem  $salaryItem
   * @return \Illuminate\Http\Response
   */
  public function destroy(SalaryItem $salaryItem)
  {
    //
  }

  public function import(Request $request, SalaryItem $salaryItem)
  {
    $validator = validator($request->all(), [
      'excel_sheet' => ['required', 'file', 'mimes:csv,xlsx,txt']
    ]);

    if ($validator->fails()) {
      return back()->with('error', $validator->errors()->first());
    }

    try {
      Excel::import(new SalaryItemImport($salaryItem), $request->file('excel_sheet'));
    } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
      return back()->with('error', $e->errors()[0][0]);
    } catch (\Throwable $th) {
      return back()->with('error', "Something went wrong, make sure you followed the template: {$th->getMessage()}");
    }

    return Redirect::back()->with('success', 'Salary items imported successfully');
  }

  public function importSample()
  {
    return Excel::download(new SampleExport((new Collection([[
      'Staff ID', 'Employee', 'Amount'
    ], User::query()
      ->select(DB::raw("staff_id,CONCAT(users.first_name,'  ',users.last_name) as employee"))
      ->where('is_admin', 0)->get(['staff_id', 'employee'])]))->toArray()), 'salary_Import_sample_data.xlsx');
  }

  public function attachUser(Request  $request, User $user)
  {
    $validator = validator($request->all(), [
      'amount' => 'required|numeric',
      'salary_item_id' => 'required|exists:salary_items,id'
    ]);
    if ($validator->fails()) {
      return  back()->with('error', $validator->errors()->first());
    }
    if ($user->salaryItems()->wherePivot('salary_item_id', $request->post('salary_item_id'))->exists() == false) {
      $user->salaryItems()->attach($request->post('salary_item_id'), [
        'amount' => $request->post('amount')
      ]);
    } else {
      $user->salaryItems()->updateExistingPivot($request->post('salary_item_id'), [
        'amount' => $request->post('amount')
      ]);
    }

    return back()->with('success', 'Salary updated');
  }

  public function detachUser(Request  $request, User $user)
  {
    $user->salaryItems()->detach($request->post('salary_item_id'));
    return back()->with('success', 'Salary updated');
  }

  public function updateUser(Request  $request, User $user)
  {
    $validator = validator($request->all(), [
      'amount' => 'required|numeric',
      'salary_item_id' => 'required|exists:salary_items,id'
    ]);
    if ($validator->fails()) {
      return  back()->with('error', $validator->errors()->first());
    }
    
    $user->salaryItems()->updateExistingPivot($request->post('salary_item_id'), [
      'amount' => $request->post('amount')
    ]);
    return back()->with('success', 'Salary updated');
  }
}
