<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Mailbox;
use App\Models\MailboxProject;
use App\Models\Project;

class MailboxProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MailboxProject::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'mailbox_id' => Mailbox::factory(),
            'project_id' => Project::factory(),
        ];
    }
}
