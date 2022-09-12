<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentStreamRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, mixed>
   */
  public function rules()
  {
    // dd($this->all());
    return [
      'name' => ['required', 'string', 'max:255'],
      'process_deductions' => ['nullable', 'boolean'],
      'include_overtime' => ['nullable', 'boolean'],
      'include_basic_salary' => ['nullable', 'boolean'],
      'payment_month' => ['required', 'date_format:Y-m'],
      'salary_items' => ['nullable', 'array'],
      'salary_items.*' => ['exists:salary_items,id'],
    ];
  }
}
