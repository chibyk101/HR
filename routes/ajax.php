<?php

use Illuminate\Support\Facades\Route;

Route::as('ajax.')->prefix('ajax')->middleware('ajax')->group(function(){
  Route::apiResource('salaryItems',\App\Http\Controllers\Ajax\SalaryItemController::class);
  Route::apiResource('salaryItems.users',\App\Http\Controllers\Ajax\SalaryItemUserController::class);
  Route::apiResource('deductions',\App\Http\Controllers\Ajax\DeductionController::class)->only('index','store','destroy');
  Route::apiResource('overtimes',\App\Http\Controllers\Ajax\OvertimeController::class)->only('index','store','destroy');
  Route::apiResource('documents',\App\Http\Controllers\Ajax\DocumentController::class)->only('index','store','destroy');
  Route::apiResource('subsidiaries',\App\Http\Controllers\Ajax\SubsidiaryController::class)->only('index','store','destroy');
  Route::apiResource('departments',\App\Http\Controllers\Ajax\DepartmentController::class)->only('index','store','destroy');
  Route::apiResource('branches',\App\Http\Controllers\Ajax\BranchController::class)->only('index','store','destroy');
  Route::apiResource('designations',\App\Http\Controllers\Ajax\DesignationController::class)->only('index','store','destroy');
  Route::apiResource('officeTypes',\App\Http\Controllers\Ajax\OfficeTypeController::class)->only('index','store','destroy');
  Route::apiResource('users',\App\Http\Controllers\Ajax\UserController::class)->only('index','destroy');
  Route::apiResource('paymentStreams.payslips',\App\Http\Controllers\Ajax\PayslipController::class)->only('index','store','destroy')->shallow();

  Route::get('search-users',[\App\Http\Controllers\Ajax\UserController::class,'search'])->name('users.search');
  Route::get('search-subsidiaries',[\App\Http\Controllers\Ajax\SubsidiaryController::class,'search'])->name('subsidiaries.search');
  Route::get('search-salaryItems',[\App\Http\Controllers\Ajax\SalaryItemController::class,'search'])->name('salaryItems.search');

});