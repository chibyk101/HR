<?php

namespace App\Http\Controllers;

use App\Exports\SampleExport;
use App\Models\Overtime;
use App\Http\Requests\UpdateOvertimeRequest;
use App\Imports\OvertimeImport;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;

class OvertimeController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('overtimes.index');
  }

  public function store(Request $request)
  {
    $validator = validator($request->all(), [
      'name' => 'required|string|max:255',
      'rate' => 'required|numeric',
      'number_of_days' => 'required|numeric',
      'hours' => 'required|numeric',
      'user_id' => 'required|exists:users,id'
    ]);

    if ($validator->fails()) {
      return back()->with('error', $validator->errors()->first());
    }

    $overtime = new Overtime($validator->validated());
    if ($overtime->newQuery()->where(['user_id' => $request->user_id, 'name' => $request->name])->exists() == false) {
      $overtime->user()->associate($request->user_id);
      $overtime->save();
      return back()->with('success', 'overtime added');
    }
    return back()->with('error', 'overtime already exist');
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Overtime  $overtime
   * @return \Illuminate\Http\Response
   */
  public function edit(Overtime $overtime)
  {
    return view('overtimes.edit', compact('overtime'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \App\Http\Requests\UpdateOvertimeRequest  $request
   * @param  \App\Models\Overtime  $overtime
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateOvertimeRequest $request, Overtime $overtime)
  {
    $overtime->fill($request->validated());
    $overtime->save();

    return back()->with('success', 'overtime updated');
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
      Excel::import(new OvertimeImport, $request->file('excel_sheet'));
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
      'Staff ID', 'Employee', 'Overtime Title', 'Rate', 'Number of days', 'Hours'
    ], User::query()
      ->select(DB::raw("staff_id,CONCAT(users.first_name,'  ',users.last_name) as employee"))
      ->where('is_admin', 0)->get(['staff_id', 'employee'])]))->toArray()), 'deduction_Import_sample_data.xlsx');
  }

  public function destroy(Overtime $overtime)
  {
    $overtime->delete();
    return back()->with('success','overtime deleted');
  }
}
