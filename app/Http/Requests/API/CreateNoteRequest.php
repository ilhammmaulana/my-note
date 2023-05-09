<?php

namespace App\Http\Requests\API;

use App\Traits\ResponseAPI;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateNoteRequest extends FormRequest
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
            "title" => "required|min:1",
            "body" => "required|min:1",
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->requestValidation(formatErrorValidatioon($validator->errors())));
    }
}
