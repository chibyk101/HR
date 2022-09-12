<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOvertimeRequest;
use App\Models\Overtime;
use Illuminate\Http\Request;

class OvertimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return [
        'overtimes' => Overtime::with('user')->latest()->paginate()
      ];
    }


    public function store(StoreOvertimeRequest $request)
    {
      foreach($request->collect('users') as $user){
        $overtime = new Overtime($request->validated());
        if($overtime->newQuery()->where(['user_id'=>$user,'name' => $request->name])->exists() == false){
          $overtime->user()->associate($user);
          $overtime->save();
        }
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Overtime  $overtime
     * @return \Illuminate\Http\Response
     */
    public function destroy(Overtime $overtime)
    {
        $overtime->delete();
    }
}
