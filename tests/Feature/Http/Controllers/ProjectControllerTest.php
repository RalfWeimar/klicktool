<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ProjectController
 */
final class ProjectControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $projects = Project::factory()->count(3)->create();

        $response = $this->get(route('projects.index'));

        $response->assertOk();
        $response->assertViewIs('project.index');
        $response->assertViewHas('projects');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('projects.create'));

        $response->assertOk();
        $response->assertViewIs('project.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProjectController::class,
            'store',
            \App\Http\Requests\ProjectStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $name = $this->faker->name();
        $slug = $this->faker->slug();
        $status = $this->faker->randomElement(/** enum_attributes **/);
        $project_start = Carbon::parse($this->faker->date());
        $project_end = Carbon::parse($this->faker->date());
        $client = Client::factory()->create();

        $response = $this->post(route('projects.store'), [
            'name' => $name,
            'slug' => $slug,
            'status' => $status,
            'project_start' => $project_start->toDateString(),
            'project_end' => $project_end->toDateString(),
            'client_id' => $client->id,
        ]);

        $projects = Project::query()
            ->where('name', $name)
            ->where('slug', $slug)
            ->where('status', $status)
            ->where('project_start', $project_start)
            ->where('project_end', $project_end)
            ->where('client_id', $client->id)
            ->get();
        $this->assertCount(1, $projects);
        $project = $projects->first();

        $response->assertRedirect(route('projects.index'));
        $response->assertSessionHas('project.id', $project->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $project = Project::factory()->create();

        $response = $this->get(route('projects.show', $project));

        $response->assertOk();
        $response->assertViewIs('project.show');
        $response->assertViewHas('project');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $project = Project::factory()->create();

        $response = $this->get(route('projects.edit', $project));

        $response->assertOk();
        $response->assertViewIs('project.edit');
        $response->assertViewHas('project');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProjectController::class,
            'update',
            \App\Http\Requests\ProjectUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $project = Project::factory()->create();
        $name = $this->faker->name();
        $slug = $this->faker->slug();
        $status = $this->faker->randomElement(/** enum_attributes **/);
        $project_start = Carbon::parse($this->faker->date());
        $project_end = Carbon::parse($this->faker->date());
        $client = Client::factory()->create();

        $response = $this->put(route('projects.update', $project), [
            'name' => $name,
            'slug' => $slug,
            'status' => $status,
            'project_start' => $project_start->toDateString(),
            'project_end' => $project_end->toDateString(),
            'client_id' => $client->id,
        ]);

        $project->refresh();

        $response->assertRedirect(route('projects.index'));
        $response->assertSessionHas('project.id', $project->id);

        $this->assertEquals($name, $project->name);
        $this->assertEquals($slug, $project->slug);
        $this->assertEquals($status, $project->status);
        $this->assertEquals($project_start, $project->project_start);
        $this->assertEquals($project_end, $project->project_end);
        $this->assertEquals($client->id, $project->client_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $project = Project::factory()->create();

        $response = $this->delete(route('projects.destroy', $project));

        $response->assertRedirect(route('projects.index'));

        $this->assertModelMissing($project);
    }
}
