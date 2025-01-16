<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Box;
use App\Models\Client;
use App\Models\Mailbox;
use App\Models\Project;

class MailboxFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Mailbox::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'slug' => $this->faker->slug(),
            'status' => $this->faker->randomElement(["active","inactive"]),
            'description' => $this->faker->text(),
            'average_time' => $this->faker->numberBetween(0, 10000),
            'average_pay' => $this->faker->numberBetween(0, 600),
            'client_id' => Client::factory(),
            'project_id' => Project::factory(),
            'box_id' => Box::factory(),
        ];
    }
}
