<?php

namespace Feature;

use App\Models\Weather;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Employee;
use Tests\TestCase;

class EmployeeApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->getJson('/api/employee');

        $response->assertStatus(200);
    }
    public function test_the_application_returns_offset_and_limit_employees_in_index()
    {
        $employees = Employee::factory(10)->create();
        $limitedToFour = $employees->random(4);

        $response = $this->getJson('/api/employee?limit=4&offset=4');
        $responseDada = $response->json();
        $this->assertCount(4, $responseDada);
        if (!empty($responseData)) {
            $firstElement = $responseData[0];
            $this->assertEquals(4, $firstElement['id']);
        }
    }
    public function test_the_application_returns_a_one_employee(): void
    {
        $employee = Employee::factory()->create();
        $response = $this->getJson('/api/employee/1');

        $response->assertJson($employee->toArray());
    }


    public function test_api_employee_store_success():void
    {
        $employee = [
            'name' => 'Denis',
            'age' => 44,
            'country' => 'Ukraine',
            'email' => 'denis@hotmail.com',
            'salary' => 1500,
            'position' => 'PHP Back-end developer'
        ];

        $response = $this->postJson('/api/employee', $employee);
        $response->assertStatus(201);
        $response->assertJson($employee);

    }
    public function test_api_employee_invalid_store_returns_error():void
    {
        $employee = [
            'name' => '',
            'age' => 44,
            'country' => 'Ukraine',
            'email' => '',
            'salary' => 1500,
            'position' => 'PHP Back-end developer'
        ];

        $response = $this->postJson('/api/employee', $employee);
        $response->assertStatus(422);

    }

    public function test_api_employee_update_success():void
    {
        Employee::factory()->create();
        $employee = [
            'name' => 'Denis',
            'age' => 44,
            'country' => 'Ukraine',
            'email' => 'denis@hotmail.com',
            'salary' => 1500,
            'position' => 'PHP Back-end developer'
        ];
        $response = $this->putJson('/api/employee/1', $employee);
        $responseData = $response->json();

        if (!empty($responseData)) {

            $this->assertEquals('Denis', $responseData['name']);
        }

    }

    public function test_api_employee_delete_succes():void
    {
        Employee::factory()->create();
        Weather::factory()->create([
            'employee_id' =>1
        ]);
        $response = $this->deleteJson('api/employee/1');
        $response->assertStatus(202);

    }

    public function test_api_employee_gets_only_by_seller_position():void
    {

    }

}
