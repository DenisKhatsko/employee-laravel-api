<?php

namespace App\Action;

use App\Services\WeatherNotificationInterface;
use App\Mail\WeatherNotify;
use Illuminate\Support\Facades\Mail;

class WeatherEmailNotificationAction implements WeatherNotificationInterface
{

    public function sendWeatherNotification($email,$message): void
    {
        Mail::to($email)->send(new WeatherNotify($message));

    }
}
