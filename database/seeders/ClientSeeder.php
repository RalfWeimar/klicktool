<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Client::factory()->create([
            'name' => 'Deutsche Bahn AG',
            'email' => 'info@bahn.de'
        ]);

        Client::factory()->create([
            'name' => 'Lichtblick AG',
            'email' => 'info@lichtblick.de'
        ]);
    }
}
