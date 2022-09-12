<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  return view('welcome');
});

Route::get('/dashboard', function () {
  return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
  //users
  Route::get('sample-data-users', [\App\Http\Controllers\UserController::class, 'importSample'])->name('users.import.sample');
  Route::post('import-data-users', [\App\Http\Controllers\UserController::class, 'import'])->name('users.import');
  Route::resource('users', \App\Http\Controllers\UserController::class);
  //subsidiaries
  Route::resource('subsidiaries', \App\Http\Controllers\SubsidiaryController::class)->except('destroy','show');
  //departments
  Route::resource('departments', \App\Http\Controllers\DepartmentController::class)->except('destroy','show');
  //branches
  Route::resource('branches', \App\Http\Controllers\BranchController::class)->except('destroy','show');
  //designation
  Route::resource('designations', \App\Http\Controllers\DesignationController::class)->except('destroy','show');
  //payment streams
  Route::put('mark-as-processed/{paymentStream}',[\App\Http\Controllers\PaymentStreamController::class,'markAsProcessed'])->name('paymentStreams.processed');
  Route::resource('paymentStreams', \App\Http\Controllers\PaymentStreamController::class);
  Route::post('payslips-pay/{paymentStream}',[\App\Http\Controllers\PayslipController::class,'pay'])->name('payslips.pay');
  Route::resource('paymentStreams.payslips', \App\Http\Controllers\PayslipController::class)->shallow();
  //salary items
  Route::post('import-salaryItems/{salaryItem}', [\App\Http\Controllers\SalaryItemController::class, 'import'])->name('salaryItems.import');
  Route::get('sample-data-salaryItems', [\App\Http\Controllers\SalaryItemController::class, 'importSample'])->name('salaryItems.import.sample');
  Route::resource('salaryItems', \App\Http\Controllers\SalaryItemController::class);

  //deductions
  Route::get('sample-data-deductions', [\App\Http\Controllers\DeductionController::class, 'importSample'])->name('deductions.import.sample');
  Route::post('import-data-deductions', [\App\Http\Controllers\DeductionController::class, 'import'])->name('deductions.import');
  Route::resource('deductions', \App\Http\Controllers\DeductionController::class)->except('create');

  //overtimes
  Route::get('sample-data-overtimes', [\App\Http\Controllers\OvertimeController::class, 'importSample'])->name('overtimes.import.sample');
  Route::post('import-data-overtimes', [\App\Http\Controllers\OvertimeController::class, 'import'])->name('overtimes.import');
  Route::resource('overtimes', \App\Http\Controllers\OvertimeController::class)->except('create');

  //documents
  Route::resource('documents',\App\Http\Controllers\DocumentController::class);
  Route::get('documents-employeeDocuments/{document}/{user}',[\App\Http\Controllers\EmployeeDocumentController::class,'create'])->name('documents.employeeDocuments.create');
  Route::post('documents-employeeDocuments/{document}/{user}',[\App\Http\Controllers\EmployeeDocumentController::class,'store'])->name('documents.employeeDocuments.store');


  //payslip update
  Route::put('update-basic-salary/{user}',[\App\Http\Controllers\PayslipController::class,'updateBasicSalary'])->name('update-basic-salary');
  Route::post('attach-user-salary-item/{user}',[\App\Http\Controllers\SalaryItemController::class,'attachUser'])->name('salaryItems.users.attach');
  Route::delete('detach-user-salary-item/{user}',[\App\Http\Controllers\SalaryItemController::class,'detachUser'])->name('salaryItems.users.detach');
  Route::put('update-user-salary-item/{user}',[\App\Http\Controllers\SalaryItemController::class,'updateUser'])->name('salaryItems.users.update');
});

// useless routes
// Just to demo sidebar dropdown links active states.
Route::get('/buttons/text', function () {
  return view('buttons-showcase.text');
})->middleware(['auth'])->name('buttons.text');

Route::get('/buttons/icon', function () {
  return view('buttons-showcase.icon');
})->middleware(['auth'])->name('buttons.icon');

Route::get('/buttons/text-icon', function () {
  return view('buttons-showcase.text-icon');
})->middleware(['auth'])->name('buttons.text-icon');

require __DIR__ . '/auth.php';
require __DIR__ . '/ajax.php';
