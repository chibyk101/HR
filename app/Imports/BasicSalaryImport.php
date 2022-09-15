<?php

namespace App\Imports;

use App\Models\User;
use App\Services\PaymentService;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class BasicSalaryImport implements ToCollection, WithHeadingRow, WithValidation
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
      $paymentService = new PaymentService;
      foreach ($collection as $item) {
        /**
         * @var User $user
         */
        $user = User::query()->firstWhere('staff_id', $item['staff_id']);
        $user->basic_salary = $item['amount'];
        $user->save();
        $paymentService->regeneratePayslip($user);
      }
    }

    public function rules(): array
    {
      return [
        'staff_id' => ['required', Rule::exists('users')->withoutTrashed() ],
        'amount' => 'required|numeric|gt:0',
      ];
    }
}
