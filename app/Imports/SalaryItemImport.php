<?php

namespace App\Imports;

use App\Models\SalaryItem;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class SalaryItemImport implements ToCollection, WithHeadingRow, WithValidation
{
  private SalaryItem $salaryItem;

  public function __construct(SalaryItem $salaryItem)
  {
    $this->salaryItem = $salaryItem;
  }
  /**
   * @param Collection $collection
   */
  public function collection(Collection $collection)
  {
    foreach ($collection as $item) {
      /**
       * @var User $user
       */
      $user = User::query()->firstWhere('staff_id', $item['staff_id']);
      if ($user->salaryItems()->wherePivot('user_id', '=', $user->id)->exists()) {
        $user->salaryItems()->updateExistingPivot($this->salaryItem, [
          'amount' => $item['amount']
        ]);
      } else {
        $user->salaryItems()->attach($this->salaryItem, [
          'amount' => $item['amount']
        ]);
      }
    }
  }

  public function rules(): array
  {
    return [
      'staff_id' => ['required|exists:users'],
      'amount' => ['required','numeric']
    ];
  }
}
