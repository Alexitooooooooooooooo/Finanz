<?php

namespace App\Http\Resources;

use App\Models\Clients;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class TransactionsCreditResource extends JsonResource
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
            'transaction_id' => $this->transaction_id,
            'client_id' => $this->client_id,
            'type' => $this->type,
            'amount' => $this->amount,
        ];
    }
}

