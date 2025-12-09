<?php

namespace App\Http\Request\Contact;

use App\Http\Request\BaseRequests;

class ContactUpdateRequest extends BaseRequests
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'sometimes',
            'email' => 'sometimes|email',
            'client_id' => 'sometimes|exists:clients,id',
        ];
    }

    public function messages(): array
    {
        return array_merge($this->generalMessages());
    }
}