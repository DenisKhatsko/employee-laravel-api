<?php

namespace Database\Seeders;

use AllowDynamicProperties;
use App\Models\Weather;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class WeatherSeeder extends Seeder
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
        Weather::factory($this->quantity)->create();
    }
}
