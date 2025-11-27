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
        'client_id',
        'transaction_date',
        'description',
    ];

    public $timestamps = false;

    public function client()
    {
        return $this->belongsTo(Clients::class, 'client_id');
    }
}
