<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UserImport implements ToModel, WithValidation, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
          'first_name' => $row['first_name'],
          'last_name' => $row['last_name'],
          'email'  => $row['email'],
          'phone'  => $row['phone'] ?? null,
          'password' => 'password',
          // 'branch_id',
          // 'designation_id',
          // 'is_admin',
          // 'dob',
          // 'gender',
          // 'phone',
          // 'address',
          // 'branch_id',
          // 'department_id',
          // 'designation_id',
          // 'company_doj',
          // 'documents',
          // 'account_holder_name',
          // 'account_number',
          // 'bank_name',
          // 'bank_identifier_code',
          // 'branch_location',
          // 'tax_payer_id',
          // 'salary_type',
          // 'salary',
          // 'created_by',
          // 'savings_account_number',
          // 'religion',
          // 'lga',
          // 'state_of_origin',
          // 'marital_status',
          // 'next_of_kin',
          // 'next_of_kin_address',
          // 'next_of_kin_phone',
          // 'guarantor_1',
          // 'guarantor_2',
          // 'guarantor_3',
          // 'guarantor_1_phone',
          // 'guarantor_2_phone',
          // 'guarantor_3_phone',
          // 'guarantor_1_address',
          // 'guarantor_2_address',
          // 'guarantor_3_address',
          // 'level',
          // 'office_type_id'
        ]);

        
    }

    public function rules(): array
    {
      return [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'gender' => 'required|in:male,female',
        'phone' => 'nullable|unique:users',
        'department' => 'nullable|exists:departments,name',
      ];
    }
}
