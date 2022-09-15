<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use App\Http\Requests\StoreDesignationRequest;
use App\Http\Requests\UpdateDesignationRequest;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request)
    {
      return [
        'designations' => Designation::when(request('q'),function($query) use($request) {
          $query->where('name', 'like', "%{$request->query('q')}%");
        })->latest()->paginate()
      ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDesignationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDesignationRequest $request)
    {
        Designation::Create($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Designation $designation)
    {
        $designation->delete();
    }

    public function search(Request $request)
    {
      return Designation::where('name', 'like', "%{$request->query('q')}%")
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
