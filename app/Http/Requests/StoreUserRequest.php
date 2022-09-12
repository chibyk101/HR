<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
    return [
      "first_name" => ['required', 'string', 'max:255'],
      "last_name" => ['required', 'string', 'max:255'],
      "email" => ['required', 'string', 'max:255','unique:users,email'],
      "phone" => ['nullable', 'string', 'max:255'],
      "dob" => ['nullable'],
      "lga" => ['nullable', 'string', 'max:255'],
      "state_of_origin" => ['nullable', 'string', 'max:255'],
      "address" => ['nullable', 'string', 'max:255'],
      "marital_status" => ['nullable', 'in:single,married'],
      "religion" => ['nullable', 'string', 'max:255'],
      "next_of_kin" => ['nullable', 'string', 'max:255'],
      "next_of_kin_phone" => ['nullable', 'string', 'max:255'],
      "next_of_kin_address" => ['nullable', 'string', 'max:255'],
      "guarantor_1" => ['nullable', 'string', 'max:255'],
      "guarantor_1_phone" => ['nullable', 'string', 'max:255'],
      "guarantor_1_address" => ['nullable', 'string', 'max:255'],
      "guarantor_2" => ['nullable', 'string', 'max:255'],
      "guarantor_2_phone" => ['nullable', 'string', 'max:255'],
      "guarantor_2_address" => ['nullable', 'string', 'max:255'],
      "guarantor_3" => ['nullable', 'string', 'max:255'],
      "guarantor_3_phone" => ['nullable', 'string', 'max:255'],
      "guarantor_3_address" => ['nullable', 'string', 'max:255'],
      "company_doj" => ['nullable'],
      "level" => ['nullable', 'numeric'],
      "departments" => ['nullable', 'array'],
      "departments.*" => ['nullable', 'exists:departments,id'],
      "designation_id" => ['nullable', 'exists:designations,id'],
      "branch_id" => ['nullable', 'exists:branches,id'],
      'gender' => ['required'],
      'password' => ['required','string','min:8'],
      'photo' => ['nullable','file','mime_types:image/*','max:1024']
    ];
  }

  public function messages()
  {
    return [
      'photo.max' => 'image can not be more than 1MB'
    ];
  }
}
