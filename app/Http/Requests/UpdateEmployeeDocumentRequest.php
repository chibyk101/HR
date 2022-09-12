<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeDocumentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->route('document')->user()->is(auth()->user());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
      return [
        'document_file' =>['required','file','mime_types:image/*,application/pdf,text/plain,application/vnd.openxmlformats-officedocument.wordprocessingml.document']
    ];
    }
}
