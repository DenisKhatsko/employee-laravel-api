<?php

namespace App\Services;

interface WeatherNotificationInterface
{
    public function sendWeatherNotification($email ,$message):void;
}
