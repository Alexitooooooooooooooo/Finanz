<?php

namespace Database\Seeders;

// use GuzzleHttp\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Client::create([
            'user_id' => 1,
            'name' => 'Javier',
            'email' => 'Javieralexfeik1@gmail.com',
            'balance' => 1000.00,
            
        ]);
    }
}
