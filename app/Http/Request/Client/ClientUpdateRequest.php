<?php
namespace App\Http\Request\Client;

use Illuminate\Foundation\Http\FormRequest; 
use App\Http\Request\BaseRequests;

class ClientUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|max:255|unique:clients,name',
            'email' => 'sometimes|email|unique:clients,email',
            'username' => 'sometimes|max:255|unique:clients,username',
        ];
    }

}