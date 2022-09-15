<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    return [
      'departments' => Department::with('subsidiary')->when(request('q'), function ($query) use ($request) {
        $query->where('name', 'like', "%{$request->query('q')}%")->orWhereHas('subsidiary', function ($query) use ($request) {
          $query->where('subsidiaries.name', 'like', "%{$request->query('q')}%");
        });
      })->latest()->paginate()
    ];
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \App\Http\Requests\StoreDepartmentRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreDepartmentRequest $request)
  {
    $department = new Department($request->validated());
    $department->save();
  }


  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Department  $department
   * @return \Illuminate\Http\Response
   */
  public function destroy(Department $department)
  {
    $department->delete();
  }

  public function search(Request $request)
  {
    return Department::where('name', 'like', "%{$request->query('q')}%")
      ->orWhereHas('subsidiary', function ($query) use ($request) {
        $query->where('subsidiaries.name', 'like', "%{$request->query('q')}%");
      })
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
