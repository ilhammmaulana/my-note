<?php

namespace App\Http\Requests\API;

use App\Traits\ResponseAPI;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SendOTPForgotPasswordRequets extends FormRequest
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
            "email" => "required|email|exists:users,email"
        ];
    }
    public function failedValidation(Validator $validator)
    {
        if ($validator->errors()->has('email') && strpos($validator->errors()->first('email'), 'invalid') !== false) {
            throw new HttpResponseException($this->requestNotFound('Account with email ' . $this->request->get('email') . ' not found , Please check your email!'));
        } else {
            throw new HttpResponseException($this->responseValidation(formatErrorValidatioon($validator->errors()), 'Failed! Must be include user id'));
        }
    }
}
