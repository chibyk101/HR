<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOvertimeRequest extends FormRequest
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
          'name' => 'required|string|max:255', 
          'rate' => 'required|numeric',
          'number_of_days' => 'required|numeric',
          'hours' => 'required|numeric',
          'users' => 'required|array',
          'users.*' => 'exists:users,id'
        ];
    }
}
