<?php

namespace App\Imports;

use App\Models\Overtime;
use App\Models\User;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class OvertimeImport implements ToModel,WithValidation,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Overtime([
          'user_id' => User::firstWhere('staff_id',$row['staff_id'])->id,
          'name' => $row['overtime_title'], 
          'rate' => $row['rate'],
          'number_of_days' => $row['number_of_days'],
          'hours' => $row['hours']
        ]);
    }
    public function rules(): array
    {
      return [
        'overtime_title' => 'required|string',
        'staff_id' =>['required', Rule::exists('users')->withoutTrashed() ],
        'rate' => 'required|numeric',
        'hours' => 'required|numeric',
        'number_of_days' => 'required|numeric',
      ];
    }
}
