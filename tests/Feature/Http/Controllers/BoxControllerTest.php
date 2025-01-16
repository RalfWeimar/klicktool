<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Box;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\BoxController
 */
final class BoxControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $boxes = Box::factory()->count(3)->create();

        $response = $this->get(route('boxes.index'));

        $response->assertOk();
        $response->assertViewIs('box.index');
        $response->assertViewHas('boxes');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('boxes.create'));

        $response->assertOk();
        $response->assertViewIs('box.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\BoxController::class,
            'store',
            \App\Http\Requests\BoxStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $name = $this->faker->name();
        $status = $this->faker->randomElement(/** enum_attributes **/);

        $response = $this->post(route('boxes.store'), [
            'name' => $name,
            'status' => $status,
        ]);

        $boxes = Box::query()
            ->where('name', $name)
            ->where('status', $status)
            ->get();
        $this->assertCount(1, $boxes);
        $box = $boxes->first();

        $response->assertRedirect(route('boxes.index'));
        $response->assertSessionHas('box.id', $box->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $box = Box::factory()->create();

        $response = $this->get(route('boxes.show', $box));

        $response->assertOk();
        $response->assertViewIs('box.show');
        $response->assertViewHas('box');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $box = Box::factory()->create();

        $response = $this->get(route('boxes.edit', $box));

        $response->assertOk();
        $response->assertViewIs('box.edit');
        $response->assertViewHas('box');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\BoxController::class,
            'update',
            \App\Http\Requests\BoxUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $box = Box::factory()->create();
        $name = $this->faker->name();
        $status = $this->faker->randomElement(/** enum_attributes **/);

        $response = $this->put(route('boxes.update', $box), [
            'name' => $name,
            'status' => $status,
        ]);

        $box->refresh();

        $response->assertRedirect(route('boxes.index'));
        $response->assertSessionHas('box.id', $box->id);

        $this->assertEquals($name, $box->name);
        $this->assertEquals($status, $box->status);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $box = Box::factory()->create();

        $response = $this->delete(route('boxes.destroy', $box));

        $response->assertRedirect(route('boxes.index'));

        $this->assertModelMissing($box);
    }
}
