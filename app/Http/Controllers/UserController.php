<?php

namespace App\Http\Controllers;

use App\Exports\SampleExport;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Imports\UserImport;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Document;
use App\Models\OfficeType;
use App\Models\Subsidiary;
use App\Notifications\WelcomeUserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('users.index', [
      'users' => User::with('departments', 'branch', 'designation')->where('is_admin', false)->paginate()
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('users.create', [
      'subsidiaries' => Subsidiary::all(['id', 'name']),
      'officeTypes' => OfficeType::all(['id','name']),
      'designations' => Designation::all(['id','name']),
      'departments' => Department::all(['id', 'name', 'subsidiary_id']),
      'branches' => Branch::all(['id', 'name', 'department_id'])
    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \App\Http\Requests\StoreUserRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreUserRequest $request)
  {
    $user = new User($request->validated());
    if($request->hasFile('photo')){
      $photo = $request->file('photo')->store('photos');
      if ($photo){
        $user->setAttribute('photo',$photo);
      }
    }
    $user->save();
    $user->departments()->attach($request->collect('departments'));
    $user->notify(new WelcomeUserNotification($request->password));
    return redirect()->route('users.index')->with('success', 'Staff Added');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\User  $user
   * @return \Illuminate\Http\Response
   */
  public function show(User $user)
  {
    return view('users.show',[
      'user' => $user->load('departments','salaryItems','deductions','overtimes','employeeDocuments'),
      'documents' => Document::all()
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\User  $user
   * @return \Illuminate\Http\Response
   */
  public function edit(User $user)
  {
    return view('users.edit', [
      'subsidiaries' => Subsidiary::all(['id', 'name']),
      'designations' => Designation::all(['id','name']),
      'officeTypes' => OfficeType::all(['id','name']),
      'departments' => Department::all(['id', 'name', 'subsidiary_id']),
      'branches' => Branch::all(['id', 'name', 'department_id']),
      'user' => $user->load('departments','branch','designation','officeType')
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \App\Http\Requests\UpdateUserRequest  $request
   * @param  \App\Models\User  $user
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateUserRequest $request, User $user)
  {
    // dd($request->validated());
    $user->fill(collect($request->validated())->except('photo')->toArray());
    if($request->hasFile('photo')){
      if($user->photo !== 'photos/default.png' && Storage::exists($user->photo)){
        Storage::delete($user->photo);
      }
      $photo = $request->file('photo')->store('photos');
      if ($photo){
        $user->setAttribute('photo',$photo);
      }
    }
    $user->save();
    $user->departments()->sync($request->collect('departments'));
    return back()->with('success', 'staff updated');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\User  $user
   * @return \Illuminate\Http\Response
   */
  public function destroy(User $user)
  {
    $user->delete();
    return back()->with('success', 'staff deleted');
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
      Excel::import(new UserImport, $request->file('excel_sheet'));
    } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
      return back()->with('error', $e->errors()[0][0]);
    } catch (\Throwable $th) {
      return back()->with('error', "Something went wrong, make sure you followed the template: {$th->getMessage()}");
    }

    return Redirect::route('users.index')->with('success', 'Users imported successfully');
  }

  public function importSample()
  {
    return Excel::download(new SampleExport([
      ['First Name', 'Last Name', 'Gender', 'Email', 'Password'],
      ['Marry', 'Magdalene', 'female', 'Marry@magdalene.com', 'alabaster%box']
    ]), 'Staff_Import_sample_data.xlsx');
  }
}
