<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class CreditTransactions extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'client_id',
        'amount',
        'type',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transactions::class, 'transaction_id');
    }

    public function client()
    {
        return $this->belongsTo(Clients::class, 'client_id');
    }
}
