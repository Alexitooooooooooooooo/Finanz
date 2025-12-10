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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public function messages(): array
    {
        return array_merge($this->generalMessages());

    }
}