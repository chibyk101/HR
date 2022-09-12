<?php

namespace App\Http\Controllers;

use App\Models\Subsidiary;
use App\Http\Requests\StoreSubsidiaryRequest;
use App\Http\Requests\UpdateSubsidiaryRequest;

class SubsidiaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('subsidiaries.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('subsidiaries.create');
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
      return back()->with('success','subsidiary created');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subsidiary  $subsidiary
     * @return \Illuminate\Http\Response
     */
    public function edit(Subsidiary $subsidiary)
    {
        return view('subsidiaries.edit',compact('subsidiary'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSubsidiaryRequest  $request
     * @param  \App\Models\Subsidiary  $subsidiary
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubsidiaryRequest $request, Subsidiary $subsidiary)
    {
        $subsidiary->update($request->validated());
        return back()->with('success','subsidiary updated');
    }
   
}
