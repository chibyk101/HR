<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PayslipExport implements FromArray, ShouldAutoSize
{
  public $data = [];
  /**
   * @param array $data the data to be exported
   */
  public function __construct(array $data)
  {
    $this->data = $data;
  }

  public function array(): array
  {
    return $this->data;
  }
}
