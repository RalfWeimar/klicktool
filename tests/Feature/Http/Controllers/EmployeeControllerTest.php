<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\EmployeeController
 */
final class EmployeeControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $employees = Employee::factory()->count(3)->create();

        $response = $this->get(route('employees.index'));

        $response->assertOk();
        $response->assertViewIs('employee.index');
        $response->assertViewHas('employees');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('employees.create'));

        $response->assertOk();
        $response->assertViewIs('employee.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EmployeeController::class,
            'store',
            \App\Http\Requests\EmployeeStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $first_name = $this->faker->firstName();
        $last_name = $this->faker->lastName();
        $email = $this->faker->safeEmail();

        $response = $this->post(route('employees.store'), [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
        ]);

        $employees = Employee::query()
            ->where('first_name', $first_name)
            ->where('last_name', $last_name)
            ->where('email', $email)
            ->get();
        $this->assertCount(1, $employees);
        $employee = $employees->first();

        $response->assertRedirect(route('employees.index'));
        $response->assertSessionHas('employee.id', $employee->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $employee = Employee::factory()->create();

        $response = $this->get(route('employees.show', $employee));

        $response->assertOk();
        $response->assertViewIs('employee.show');
        $response->assertViewHas('employee');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $employee = Employee::factory()->create();

        $response = $this->get(route('employees.edit', $employee));

        $response->assertOk();
        $response->assertViewIs('employee.edit');
        $response->assertViewHas('employee');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EmployeeController::class,
            'update',
            \App\Http\Requests\EmployeeUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $employee = Employee::factory()->create();
        $first_name = $this->faker->firstName();
        $last_name = $this->faker->lastName();
        $email = $this->faker->safeEmail();

        $response = $this->put(route('employees.update', $employee), [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
        ]);

        $employee->refresh();

        $response->assertRedirect(route('employees.index'));
        $response->assertSessionHas('employee.id', $employee->id);

        $this->assertEquals($first_name, $employee->first_name);
        $this->assertEquals($last_name, $employee->last_name);
        $this->assertEquals($email, $employee->email);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $employee = Employee::factory()->create();

        $response = $this->delete(route('employees.destroy', $employee));

        $response->assertRedirect(route('employees.index'));

        $this->assertModelMissing($employee);
    }
}
