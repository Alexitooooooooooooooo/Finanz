<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transactions extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'type',
    ];

    public function clients()
    {
        return $this->belongsToMany(Clients::class, 'client_transaction', 'transaction_id', 'client_id');
    }
}
