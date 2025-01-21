<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Ralf Weimar',
            'email' => 'ralfweimar@live.de',
            'password' => "simone_01",
        ]);

        $this->call([
            ClientSeeder::class,
            ContactSeeder::class,
            /* ProjectSeeder::class,
            MailboxSeeder::class, */
        ]);
    }
}
