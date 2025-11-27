<?php
namespace App\Http\Request\Client;

use Illuminate\Foundation\Http\FormRequest; 
use App\Http\Request\BaseRequests;

class ClientCreateRequest extends BaseRequests
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'name' => 'required|max:255|unique:clients,name',
            'email' => 'required|email|unique:clients,email',
        ];
    }

    public function messages(): array
    {
        return array_merge($this->generalMessages());

    }
}