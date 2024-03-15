<?php

namespace Feature;

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeePdfGenerationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function employeeDataCanBeDownloadedAsPdf(): void
    {
        Employee::factory()->create();

        $response = $this->getJson('/api/v1/employee/1/pdf');

        $this->assertEquals('application/pdf', $response->headers->get('Content-Type'));
        $this->assertEquals('attachment; filename="employee-1.pdf"', $response->headers->get('Content-Disposition'));
    }

    /** @test */
    public function employeeDataDownloadFailsWithInvalidEmployee(): void
    {

        $response = $this->getJson('/api/v1/employee/666/pdf');

        $response->assertStatus(404);

    }
}
