<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOfficeTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOfficeTypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OfficeType  $officeType
     * @return \Illuminate\Http\Response
     */
    public function show(OfficeType $officeType)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OfficeType  $officeType
     * @return \Illuminate\Http\Response
     */
    public function destroy(OfficeType $officeType)
    {
        //
    }
}
