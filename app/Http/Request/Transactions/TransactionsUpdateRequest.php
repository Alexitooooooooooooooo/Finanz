<?php
namespace App\Http\Request\Transactions;

use Illuminate\Foundation\Http\FormRequest; 
use App\Http\Request\BaseRequests;

class TransactionsRequest extends BaseRequests
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_id' => 'required|integer|exists:clients,id',
            'amount' => 'required|numeric',
            'type' => 'required|in:credit,debit',
            'description' => 'sometimes|string|max:500',
        ];
    }

    public function messages(): array
    {
        return array_merge($this->generalMessages());

    }
}