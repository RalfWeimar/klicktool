<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Mailbox;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\MailboxController
 */
final class MailboxControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $mailboxes = Mailbox::factory()->count(3)->create();

        $response = $this->get(route('mailboxes.index'));

        $response->assertOk();
        $response->assertViewIs('mailbox.index');
        $response->assertViewHas('mailboxes');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('mailboxes.create'));

        $response->assertOk();
        $response->assertViewIs('mailbox.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MailboxController::class,
            'store',
            \App\Http\Requests\MailboxStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $name = $this->faker->name();
        $slug = $this->faker->slug();
        $status = $this->faker->randomElement(/** enum_attributes **/);
        $average_time = $this->faker->numberBetween(-100000, 100000);
        $average_pay = $this->faker->numberBetween(-100000, 100000);

        $response = $this->post(route('mailboxes.store'), [
            'name' => $name,
            'slug' => $slug,
            'status' => $status,
            'average_time' => $average_time,
            'average_pay' => $average_pay,
        ]);

        $mailboxes = Mailbox::query()
            ->where('name', $name)
            ->where('slug', $slug)
            ->where('status', $status)
            ->where('average_time', $average_time)
            ->where('average_pay', $average_pay)
            ->get();
        $this->assertCount(1, $mailboxes);
        $mailbox = $mailboxes->first();

        $response->assertRedirect(route('mailboxes.index'));
        $response->assertSessionHas('mailbox.id', $mailbox->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $mailbox = Mailbox::factory()->create();

        $response = $this->get(route('mailboxes.show', $mailbox));

        $response->assertOk();
        $response->assertViewIs('mailbox.show');
        $response->assertViewHas('mailbox');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $mailbox = Mailbox::factory()->create();

        $response = $this->get(route('mailboxes.edit', $mailbox));

        $response->assertOk();
        $response->assertViewIs('mailbox.edit');
        $response->assertViewHas('mailbox');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MailboxController::class,
            'update',
            \App\Http\Requests\MailboxUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $mailbox = Mailbox::factory()->create();
        $name = $this->faker->name();
        $slug = $this->faker->slug();
        $status = $this->faker->randomElement(/** enum_attributes **/);
        $average_time = $this->faker->numberBetween(-100000, 100000);
        $average_pay = $this->faker->numberBetween(-100000, 100000);

        $response = $this->put(route('mailboxes.update', $mailbox), [
            'name' => $name,
            'slug' => $slug,
            'status' => $status,
            'average_time' => $average_time,
            'average_pay' => $average_pay,
        ]);

        $mailbox->refresh();

        $response->assertRedirect(route('mailboxes.index'));
        $response->assertSessionHas('mailbox.id', $mailbox->id);

        $this->assertEquals($name, $mailbox->name);
        $this->assertEquals($slug, $mailbox->slug);
        $this->assertEquals($status, $mailbox->status);
        $this->assertEquals($average_time, $mailbox->average_time);
        $this->assertEquals($average_pay, $mailbox->average_pay);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $mailbox = Mailbox::factory()->create();

        $response = $this->delete(route('mailboxes.destroy', $mailbox));

        $response->assertRedirect(route('mailboxes.index'));

        $this->assertModelMissing($mailbox);
    }
}
