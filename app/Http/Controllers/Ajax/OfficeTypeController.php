<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\OfficeType;
use App\Http\Requests\StoreOfficeTypeRequest;
use Illuminate\Http\Request;

class OfficeTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      return [
        'officeTypes' => OfficeType::when(request('q'),function($query) use($request) {
          $query->where('name', 'like', "%{$request->query('q')}%");
        })->latest()->paginate()
      ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOfficeTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOfficeTypeRequest $request)
    {
        OfficeType::create($request->validated());
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OfficeType  $officeType
     * @return \Illuminate\Http\Response
     */
    public function destroy(OfficeType $officeType)
    {
        $officeType->delete();
    }

    public function search(Request $request)
    {
      return OfficeType::where('name', 'like', "%{$request->query('q')}%")
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
