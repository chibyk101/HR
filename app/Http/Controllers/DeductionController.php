<?php

namespace App\Http\Controllers;

use App\Exports\SampleExport;
use App\Models\Deduction;
use App\Http\Requests\StoreDeductionRequest;
use App\Http\Requests\UpdateDeductionRequest;
use App\Imports\DeductionImport;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;

class DeductionController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('deductions.index');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $validator = validator($request->all(), [
      'name' => 'required|string|max:255',
      'user_id' => 'required|exists:users,id',
      'amount' => 'required|numeric',
      'is_active' => 'boolean'
    ]);

    if ($validator->fails()) {
      return back()->with('error', $validator->errors()->first());
    }
    $deduction = new Deduction($validator->validated());
    if (Deduction::query()->withoutGlobalScope('is_active_deduction')->where(['user_id' => $request->user_id, 'name' => $request->name])->exists() == false) {
      $deduction->user()->associate($request->user_id);
      $deduction->save();

      return back()->with('success', 'deduction added');
    }
    return back()->with('error', 'deduction already exist');
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Deduction  $deduction
   * @return \Illuminate\Http\Response
   */
  public function edit(Deduction $deduction)
  {
    return view('deductions.edit', compact('deduction'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \App\Http\Requests\UpdateDeductionRequest  $request
   * @param  \App\Models\Deduction  $deduction
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateDeductionRequest $request, Deduction $deduction)
  {
    $deduction->fill($request->validated());
    $deduction->is_active = $request->filled('is_active');
    $deduction->save();

    return back()->with('success', 'deduction updated');
  }



  public function import(Request $request)
  {
    $validator = validator($request->all(), [
      'excel_sheet' => ['required', 'file', 'mimes:csv,xlsx,txt']
    ]);

    if ($validator->fails()) {
      return back()->with('error', $validator->errors()->first());
    }

    try {
      Excel::import(new DeductionImport, $request->file('excel_sheet'));
    } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
      return back()->with('error', $e->errors()[0][0]);
    } catch (\Throwable $th) {
      return back()->with('error', "Something went wrong, make sure you followed the template: {$th->getMessage()}");
    }

    return Redirect::route('deductions.index')->with('success', 'deductions imported successfully');
  }

  public function importSample()
  {
    return Excel::download(new SampleExport((new Collection([[
      'Staff ID', 'Employee', 'Deduction Title', 'Amount'
    ], User::query()
      ->select(DB::raw("staff_id,CONCAT(users.first_name,'  ',users.last_name) as employee"))
      ->where('is_admin', 0)->get(['staff_id', 'employee'])]))->toArray()), 'deduction_Import_sample_data.xlsx');
  }

  public function destroy(Deduction $deduction)
  {
    $deduction->delete();
    return back()->with('success', 'deduction deleted');
  }
}
