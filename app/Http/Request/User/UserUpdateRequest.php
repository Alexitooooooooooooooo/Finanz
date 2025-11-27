<?php
namespace App\Http\Request\User;

use Illuminate\Foundation\Http\FormRequest; 
use App\Http\Request\BaseRequests;

class UserUpdateRequest extends BaseRequests
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email',
            'password' => 'sometimes|string|min:8|confirmed',
            'username' => 'sometimes|string|max:50|unique:users,username',
        ];
    }

    public function messages(): array
    {
        return array_merge($this->generalMessages());

    }
}