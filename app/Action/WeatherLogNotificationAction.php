<?php

namespace App\Action;

use App\Services\WeatherNotificationInterface;
use Illuminate\Support\Facades\Log;

class WeatherLogNotificationAction implements WeatherNotificationInterface
{

    public function sendWeatherNotification($email, $message): void
    {
        Log::channel('weather_notification')->info('user with e-mail '.$email.' Yor message is: '.$message);
    }
}
