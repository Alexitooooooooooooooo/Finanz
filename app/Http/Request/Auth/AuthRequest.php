<?php
namespace App\Http\Request\Auth;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Request\BaseRequests;

class AuthRequest extends BaseRequests
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    public function messages(): array
    {
        return array_merge($this->generalMessages());
    }
}