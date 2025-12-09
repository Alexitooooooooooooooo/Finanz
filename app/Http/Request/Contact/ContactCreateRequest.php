<?php

namespace App\Http\Request\Contact;

use App\Http\Request\BaseRequests;

class ContactCreateRequest extends BaseRequests
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'client_id' => 'required|exists:clients,id',
        ];
    }

    public function messages(): array
    {
        return array_merge($this->generalMessages());
    }
}