<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Services\UpdateWeatherService;
use Symfony\Component\Console\Command\Command as CommandAlias;

class UpdateWeather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-weather';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Employee Weather Data';

    /**
     * Execute the console command.
     */
    public function handle(UpdateWeatherService $weatherService)
    {
        try {
            $weatherService->handle();
        } catch (\Exception $e) {

            Log::channel('api')->info($e->getMessage());
        }

        return CommandAlias::SUCCESS;
    }

}
