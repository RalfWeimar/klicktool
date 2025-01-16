<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Client;
use App\Models\Project;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'status' => $this->faker->randomElement(["planned","active","finished"]),
            'project_start' => $this->faker->date(),
            'project_end' => $this->faker->date(),
            'description' => $this->faker->text(),
            'client_id' => Client::factory(),
        ];
    }
}
