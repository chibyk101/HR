<?php

namespace App\Http\Controllers;

use App\Models\OfficeType;
use App\Http\Requests\StoreOfficeTypeRequest;
use App\Http\Requests\UpdateOfficeTypeRequest;

class OfficeTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('officeTypes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('officeTypes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOfficeTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOfficeTypeRequest $request)
    {
      $officeType = new OfficeType($request->validated());
      $officeType->save();
      return  back()->with('success','office type created');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OfficeType  $officeType
     * @return \Illuminate\Http\Response
     */
    public function edit(OfficeType $officeType)
    {
        return view('officeTypes.edit',compact('officeType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOfficeTypeRequest  $request
     * @param  \App\Models\OfficeType  $officeType
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOfficeTypeRequest $request, OfficeType $officeType)
    {
      $officeType->update($request->validated());
      return  back()->with('success','office type created');
    }
  
}
