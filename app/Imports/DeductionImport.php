<?php

namespace App\Imports;

use App\Models\Deduction;
use App\Models\User;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class DeductionImport implements ToModel, WithHeadingRow, WithValidation
{
  /**
   * @param array $row
   *
   * @return \Illuminate\Database\Eloquent\Model|null
   */
  public function model(array $row)
  {
    return new Deduction([
      'name' => $row['deduction_title'],
      'amount' => $row['amount'],
      'user_id' => User::firstWhere('staff_id',$row['staff_id'])->id,
    ]);
  }
  public function rules(): array
  {
    return [
      'deduction_title' => 'required|string',
      'staff_id' => ['required', Rule::exists('users')->withoutTrashed() ],
      'amount' => 'required|numeric'
    ];
  }
}
