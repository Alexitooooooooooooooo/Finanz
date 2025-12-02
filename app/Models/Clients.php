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
        'use_amount',
    ];

    public function transactions()
    {
        return $this->hasMany(Transactions::class, 'client_id');
    }
}
