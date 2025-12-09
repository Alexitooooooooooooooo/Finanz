<?php

namespace App\Http\Resources;

use App\Models\Client;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class TransactionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    
    public function toArray(Request $request): array
    {

        $this->whenLoaded('client');

        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'type' => $this->type,
            'description' => $this->description?:'',
            'transaction_date' => $this->transaction_date,
            'client_id' => $this->client_id,
            'client_name' => optional($this->client)->name,
            'use_amount' => $this->use_amount,
        ];
    }
}