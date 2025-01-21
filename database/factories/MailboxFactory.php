<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Mailbox;

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
            'name' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'status' => $this->faker->randomElement(["active","inactive","pending"]),
            'info' => $this->faker->text(),
            'average_time' => $this->faker->randomNumber(),
            'average_pay' => $this->faker->randomNumber(),
        ];
    }
}
