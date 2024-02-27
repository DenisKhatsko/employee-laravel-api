<?php

namespace App\Console\Commands;

use App\Services\WeatherNotificationService;
use Illuminate\Console\Command;

class NotifyEmployee extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notify-employee';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send an email o log with a warning about the weather';

    /**
     * Execute the console command.
     */
    public function handle(WeatherNotificationService $notificationService)
    {
        $notificationService->handleNotification();
    }
}
