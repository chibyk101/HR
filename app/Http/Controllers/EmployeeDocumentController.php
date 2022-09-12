<?php

namespace App\Http\Controllers;

use App\Models\EmployeeDocument;
use App\Http\Requests\StoreEmployeeDocumentRequest;
use App\Http\Requests\UpdateEmployeeDocumentRequest;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class EmployeeDocumentController extends Controller
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
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create(Document $document, User $user)
  {
    return view('employee-documents.create',[
      'document'=> $document,
      'user'=>$user
    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \App\Http\Requests\StoreEmployeeDocumentRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreEmployeeDocumentRequest $request, Document $document, User $user)
  {
    $employeeDocument = new EmployeeDocument();
    $employeeDocument->document()->associate($document);
    $employeeDocument->document_file = $request->file('document_file')->store('documents');
    $user->employeeDocuments()->save($employeeDocument);

    return back()->with('success', 'document uploaded successfully');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\EmployeeDocument  $employeeDocument
   * @return \Illuminate\Http\Response
   */
  public function show(EmployeeDocument $employeeDocument)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\EmployeeDocument  $employeeDocument
   * @return \Illuminate\Http\Response
   */
  public function edit(EmployeeDocument $employeeDocument)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \App\Http\Requests\UpdateEmployeeDocumentRequest  $request
   * @param  \App\Models\EmployeeDocument  $employeeDocument
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateEmployeeDocumentRequest $request, EmployeeDocument $employeeDocument)
  {
    if (Storage::exists($employeeDocument->document_file)) {
      Storage::delete($employeeDocument->document_file);
    }
    $employeeDocument->document_file = $request->file('document_file')->store('documents');
    $employeeDocument->save();

    return back()->with('success', 'document uploaded successfully');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\EmployeeDocument  $employeeDocument
   * @return \Illuminate\Http\Response
   */
  public function destroy(EmployeeDocument $employeeDocument)
  {
    $employeeDocument->delete();
  }
}
