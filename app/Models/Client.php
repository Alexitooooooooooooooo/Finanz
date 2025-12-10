<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'balance',
        'username',
    ];

    public function transactions()
    {
        return $this->hasMany(Transactions::class, 'client_id');
    }

    public function creditTransactions()
    {
        return $this->hasMany(CreditTransactions::class, 'client_id');
    }
    public function contact()
    {
        return $this->hasMany(Contact::class, 'client_id');
    }
}
