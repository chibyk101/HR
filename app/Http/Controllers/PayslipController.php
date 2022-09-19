<?php

namespace App\Http\Controllers;

use App\Exports\PayslipExport;
use App\Exports\SampleExport;
use App\Http\Middleware\EnsurePaymentStreamIsNotProcessed;
use App\Models\Payslip;
use App\Http\Requests\StorePayslipRequest;
use App\Http\Requests\UpdatePayslipRequest;
use App\Imports\BasicSalaryImport;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Designation;
use App\Models\OfficeType;
use App\Models\PaymentStream;
use App\Models\SalaryItem;
use App\Models\User;
use App\Services\PaymentService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;

class PayslipController extends Controller
{
  public function __construct() {
    $this->middleware(EnsurePaymentStreamIsNotProcessed::class)->except('show');
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(PaymentStream $paymentStream)
  {
    return view('payslips.index', [
      'paymentStream' => $paymentStream,
      'departments' => Department::all(['id', 'name']),
      'branches' => Branch::all(['id', 'name']),
      'designations' => Designation::all(['id', 'name']),
      'office_types' => OfficeType::all(['id', 'name'])
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create(PaymentStream $paymentStream)
  {
    return view('payslips.create', [
      'paymentStream' => $paymentStream,
      'departments' => Department::all(['id', 'name']),
      'branches' => Branch::all(['id', 'name']),
      'designations' => Designation::all(['id', 'name']),
      'office_types' => OfficeType::all(['id', 'name'])
    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \App\Http\Requests\StorePayslipRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StorePayslipRequest $request, PaymentStream $paymentStream, PaymentService $paymentService)
  {
    try {
      $paymentService->generatePayslips($request->validated(), $paymentStream);
      return back()->with('success', 'payslips generated');
    } catch (\Throwable $th) {
      return back()->with('error',$th->getMessage());
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Payslip  $payslip
   * @return \Illuminate\Http\Response
   */
  public function show(Payslip $payslip)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Payslip  $payslip
   * @return \Illuminate\Http\Response
   */
  public function edit(Payslip $payslip)
  {
    $payslip->load(['user'=> function($query){
      $query->with(['deductions' => fn($q) => $q->withoutGlobalScope('is_active_deduction'),'salaryItems','overtimes']);
    },'paymentStream']);
    return view('payslips.edit',compact('payslip'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \App\Http\Requests\UpdatePayslipRequest  $request
   * @param  \App\Models\Payslip  $payslip
   * @return \Illuminate\Http\Response
   */
  public function update(UpdatePayslipRequest $request, Payslip $payslip)
  {
    //
  }

  public function pay(Request $request, PaymentStream $paymentStream)
  {
    $payslips = $paymentStream->payslips()->getQuery()->whereHas('user',function($query){
      $query->where('basic_salary','>',0);
    })->with(['user'=> function($query){
      $query->with(['deductions','salaryItems','overtimes']);
    },'paymentStream'])->where([
      'paying_id' => $request->post('paying_id'),
      'paying_by' => $request->post('paying_by'),
      'paid_at' => null,
    ])->get();
    $count = $payslips->count();
    $export = [];
    if ($count) {
      foreach ($payslips as $slip) {
        $data = [
          'Employee' => $slip->user->name,
          'Account number' => $slip->user->account_number,
          'Bank name' => $slip->user->bank_name,
          'Net pay' => $slip->net_payable,
          'Gross pay' => $slip->gross_payable,
        ];
        //enter all salary items
        foreach (SalaryItem::where('is_active', true)->get(['id', 'name']) as $salaryItem) {
          $item = $slip->user->salaryItems->where('id', 1)->first();
          $data[$salaryItem->name] = $item ? $item->pivot->amount : 0;
        }
        //sum all deductions
        $data['Total deductions'] = $slip->user->deductions->sum('amount');

        $export[] = $data;
        //set payslip as paid
        $slip->paid_at = now();
        $slip->save();
        // $slip->update(['paid_at',now()]);
      }
      //set headings in export
      array_unshift($export, array_keys($export[0]));

      $paymentStream->update(['processed_at',now()]);

      return Excel::download(new PayslipExport($export), \Illuminate\Support\Str::slug($paymentStream->name) . '-salary-export.xlsx');
    }

    return back()->with('error', 'no salaries to export');
  }

  public function updateBasicSalary(Request $request,User $user)
  {
    $validator = validator($request->all(),[
      'basic_salary' => 'required|numeric'
    ]);
    if($validator->fails()){
      return  back()->with('error',$validator->errors()->first());
    }
    $user->setAttribute('basic_salary',$request->post('basic_salary'));
    $user->save();
    return back()->with('success','Salary updated');
  }

  public function importBasicSalary(Request $request)
  {
    $validator = validator($request->all(), [
      'excel_sheet' => ['required', 'file', 'mimes:csv,xlsx,txt']
    ]);

    if ($validator->fails()) {
      return back()->with('error', $validator->errors()->first());
    }

    try {
      Excel::import(new BasicSalaryImport, $request->file('excel_sheet'));
    } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
      return back()->with('error', $e->errors()[0][0]);
    } catch (\Throwable $th) {
      return back()->with('error', "Something went wrong, make sure you followed the template: {$th->getMessage()}");
    }

    return Redirect::back()->with('success', 'Basic Salaries imported successfully');
  }

  public function importBasicSalarySample ()
  {
    return Excel::download(new SampleExport((new Collection([[
      'Staff ID', 'Employee', 'Amount'
    ], User::query()
      ->select(DB::raw("staff_id,CONCAT(users.first_name,'  ',users.last_name) as employee"))
      ->where('is_admin', 0)->get(['staff_id', 'employee'])]))->toArray()), 'salary_Import_sample_data.xlsx');
  }
}
