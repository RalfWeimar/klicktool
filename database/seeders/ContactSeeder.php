<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contact::factory()->create([
            'first_name' => 'Heinz',
            'last_name' => 'Müller',
            'email' => 'heinz.mueller@bahn.de',
            'client_id' => 1
        ]);

        Contact::factory()->create([
            'first_name' => 'Manfred',
            'last_name' => 'Schmidt',
            'email' => 'manfred.schmidt@lichtblick.de',
            'client_id' => 2
        ]);

        Contact::factory()->create([
            'first_name' => 'Ursula',
            'last_name' => 'Teslat',
            'email' => 'ursula.teslat@bahn.de',
            'client_id' => 1
        ]);
    }
}
