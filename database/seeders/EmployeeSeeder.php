<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    private int $quantity;

    public function __construct()
    {
        $this->quantity = config('app.weather_api.users_quantity');
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employee::factory($this->quantity)->create();
    }
}
