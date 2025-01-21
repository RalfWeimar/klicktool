<?php

namespace Database\Seeders;

use App\Models\Mailbox;
use Illuminate\Database\Seeder;

class MailboxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Mailbox::factory()->count(5)->create();
    }
}
