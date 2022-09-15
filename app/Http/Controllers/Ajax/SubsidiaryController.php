<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Subsidiary;
use App\Http\Requests\StoreSubsidiaryRequest;
use App\Http\Requests\UpdateSubsidiaryRequest;
use Illuminate\Http\Request;

class SubsidiaryController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    return [
      'subsidiaries' => Subsidiary::query()->when(request('q'), function ($query) use ($request) {
        $query->where('name', 'like', "%{$request->query('q')}%");
      })->paginate()
    ];
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \App\Http\Requests\StoreSubsidiaryRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreSubsidiaryRequest $request)
  {
    $subsidiary = new Subsidiary($request->validated());
    $subsidiary->save();
  }


  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Subsidiary  $subsidiary
   * @return \Illuminate\Http\Response
   */
  public function destroy(Subsidiary $subsidiary)
  {
    $subsidiary->delete();
  }

  public function search(Request $request)
  {
    return Subsidiary::where('name', 'like', "%{$request->query('q')}%")
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
