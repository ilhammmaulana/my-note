<?php

namespace App\Http\Requests\API;

use App\Traits\ResponseAPI;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class PinNoteRequest extends FormRequest
{
    use ResponseAPI;

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
     * @return array
     */
    public function rules()
    {
        return [
            "pinned" => "required|boolean"
        ];
    }
    public function failedValidation(Validator $validator)
    {
        if ($validator->errors()) {
            return $this->requestValidation($validator->errors());
        }
    }
}
