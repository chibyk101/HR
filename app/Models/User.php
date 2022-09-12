<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Observers\UserObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable, SoftDeletes, Prunable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'first_name',
    'last_name',
    'middle_name',
    'email',
    'password',
    'branch_id',
    'designation_id',
    'is_admin',
    'dob',
    'gender',
    'phone',
    'address',
    'branch_id',
    'department_id',
    'designation_id',
    'company_doj',
    'documents',
    'account_holder_name',
    'account_number',
    'bank_name',
    'bank_identifier_code',
    'branch_location',
    'tax_payer_id',
    'salary_type',
    'salary',
    'created_by',
    'savings_account_number',
    'religion',
    'lga',
    'state_of_origin',
    'marital_status',
    'next_of_kin',
    'next_of_kin_address',
    'next_of_kin_phone',
    'office_location',
    'guarantor_1',
    'guarantor_2',
    'guarantor_3',
    'guarantor_1_phone',
    'guarantor_2_phone',
    'guarantor_3_phone',
    'guarantor_1_address',
    'guarantor_2_address',
    'guarantor_3_address',
    'level',
    'staff_id',
    'office_type_id',
    'photo'
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  protected $dates = [
    'dob',
    'company_doj'
  ];

  protected $appends = [
    'name'
  ];

  public function getNameAttribute()
  {
    return $this->first_name . " " . ($this->middle_name ?  $this->middle_name . " "  : " ") . $this->last_name;
  }

  /**
   * all payslips history
   */
  public function payslips()
  {
    return $this->hasMany(Payslip::class);
  }

  /**
   * all user deductions
   */

  public function deductions()
  {
    return $this->hasMany(Deduction::class);
  }

  public function salaryItems()
  {
    return $this->belongsToMany(SalaryItem::class)->using(SalaryItemUser::class)->withPivot('amount');
  }

  public function overtimes()
  {
    return $this->hasMany(Overtime::class);
  }

  public function designation()
  {
    return $this->belongsTo(Designation::class);
  }

  public function officeType()
  {
    return $this->belongsTo(OfficeType::class);
  }

  public function departments()
  {
    return $this->belongsToMany(Department::class);
  }

  public function branch()
  {
    return $this->belongsTo(Branch::class);
  }
  public function setPasswordAttribute($value)
  {
    $this->attributes['password'] = Hash::make($value);
  }

   public function prunable()
   {
    return static::where('deleted_at','<=',now()->subDays(60));
   }

   public function employeeDocuments()
   {
    return $this->hasMany(EmployeeDocument::class);
   }

   public function grossPay()
   {
    $overtime = $this->overtimes()->sum('total');
    $salaryItems = $this->salaryItems()->sum('amount');

    return round($overtime + $salaryItems + $this->basic_salary,2);
   }

   static function booted()
   {
    static::observe(new UserObserver);
   }
}
