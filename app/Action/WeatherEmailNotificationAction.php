<?php

namespace App\Action;

use App\Mail\WeatherNotify;
use App\Services\WeatherNotificationInterface;
use Illuminate\Support\Facades\Mail;

class WeatherEmailNotificationAction implements WeatherNotificationInterface
{
    public function sendWeatherNotification($email, $message): void
    {
        Mail::to($email)->send(new WeatherNotify($message));
    }
}
