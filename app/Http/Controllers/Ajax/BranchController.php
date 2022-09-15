<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Http\Requests\StoreBranchRequest;
use App\Http\Requests\UpdateBranchRequest;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      return [
        'branches' => Branch::with('department')->when(request('q'),function($query) use($request) {
          $query->where('name', 'like', "%{$request->query('q')}%")->orWhereHas('department',function($query) use($request) {
            $query->where('departments.name', 'like', "%{$request->query('q')}%");
          });
        })->latest()->paginate()
      ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBranchRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBranchRequest $request)
    {
        Branch::create($request->validated());
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branch $branch)
    {
        $branch->delete();
    }

    public function search(Request $request)
    {
      return Branch::where('name', 'like', "%{$request->query('q')}%")
        ->orWhereHas('department', function ($query) use ($request) {
          $query->where('departments.name', 'like', "%{$request->query('q')}%");
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
