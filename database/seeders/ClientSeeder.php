<?php

namespace Database\Seeders;

use GuzzleHttp\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Clients;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Clients::create([
            'user_id' => 1,
            'name' => 'Javier',
            'email' => 'Javieralexfeik1@gmail.com',
            'balance' => 1000.00,
            
        ]);
    }
}
