<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Clients extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'balance',
    ];

    public function transactions()
    {
        return $this->belongsToMany(Transaction::class, 'client_transaction', 'client_id', 'transaction_id');
    }
}
