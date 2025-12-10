<?php

namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequests extends FormRequest
{
    public function generalMessages(): array
    {
        return [
            'name.required' => 'NAME_REQUIRED',
            'name.max' => 'NAME_MAX',
            'name.unique' => 'NAME_UNIQUE',
            'email.required' => 'EMAIL_REQUIRED',
            'email.email' => 'EMAIL_INVALID',
            'email.unique' => 'EMAIL_UNIQUE',
            'description.required' => 'DESCRIPTION_REQUIRED',
            'description.max' => 'DESCRIPTION_MAX',
            'username.required' => 'USERNAME_REQUIRED',
            'username.unique' => 'USERNAME_UNIQUE',
            'password.required' => 'PASSWORD_REQUIRED',
            "user_id.required" => "USER_ID_REQUIRED",
            "user_id.integer" => "USER_ID_FORMAT_INVALID",
            "user_id.exists" => "USER_ID_NOT_FOUND",
            "client_id.required" => "CLIENT_ID_REQUIRED",
            "client_id.integer" => "CLIENT_ID_FORMAT_INVALID",
            "client_id.exists" => "CLIENT_ID_NOT_FOUND",
            

        ];
    }

        public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation failed.',
            'error'  => $validator->errors()
        ], 422));
    }
}