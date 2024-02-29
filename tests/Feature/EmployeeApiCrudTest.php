<?php

namespace Feature;

use App\Models\Employee;
use App\Models\Weather;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeApiCrudTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_application_returns_a_successful_response(): void
    {
        $response = $this->getJson('/api/v1/employee');

        $response->assertStatus(200);
    }

    /** @test */
    public function the_application_returns_offset_and_limit_employees_in_index()
    {
        Employee::factory(10)->create();

        $response = $this->getJson('/api/v1/employee?limit=4&offset=4');
        $responseDada = $response->json();

        $this->assertCount(4, $responseDada);
        if (! empty($responseData)) {
            $firstElement = $responseData[0];
            $this->assertEquals(4, $firstElement['id']);
        }
    }

    /** @test */
    public function the_application_returns_one_employee(): void
    {
        Employee::factory()->create(['email' => 'www@com.com']);

        $response = $this->getJson('/api/v1/employee/1');
        $responseData = $response->json();

        $this->assertEquals('www@com.com', $responseData['email']);

    }

    /** @test */
    public function api_employee_store_success(): void
    {
        $employee = [
            'name' => 'Denis',
            'age' => 44,
            'country' => 'Ukraine',
            'email' => 'denis@hotmail.com',
            'salary' => 1500,
            'position' => 'PHP Back-end developer',
        ];

        $response = $this->postJson('/api/v1/employee', $employee);

        $response->assertStatus(201)
            ->assertJson($employee);

    }

    /** @test */
    public function api_employee_invalid_store_returns_error(): void
    {
        $employee = [
            'name' => '',
            'age' => 44,
            'country' => 'Ukraine',
            'email' => '',
            'salary' => 1500,
            'position' => 'PHP Back-end developer',
        ];

        $response = $this->postJson('/api/v1/employee', $employee);

        $response->assertStatus(422);

    }

    /** @test */
    public function api_employee_update_success(): void
    {
        Employee::factory()->create();
        $employee = [
            'name' => 'Denis',
            'age' => 44,
            'country' => 'Ukraine',
            'email' => 'denis@hotmail.com',
            'salary' => 1500,
            'position' => 'PHP Back-end developer',
        ];

        $response = $this->putJson('/api/v1/employee/1', $employee);
        $responseData = $response->json();

        if (! empty($responseData)) {
            $this->assertEquals('Denis', $responseData['name']);
        }

    }

    /** @test */
    public function api_employee_delete_success(): void
    {
        Employee::factory()->create();
        Weather::factory()->create([
            'employee_id' => 1,
        ]);
        $response = $this->deleteJson('api/v1/employee/1');

        $response->assertStatus(202);

    }

    /** @test */
    public function api_employee_gets_only_by_seller_position(): void
    {

    }
}
