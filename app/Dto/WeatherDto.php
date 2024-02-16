<?php

namespace App\Dto;

class WeatherDto
{
    private array $weather;

    public function setWeatherToCountry($country, $data):void
    {
        $this->weather[$country]['code'] = $data['weather'][0]['id'] ?? 0;

    }

    public function getWeatherCodeByCountry($country):int
    {
        return $this->weather[$country]['code'];
    }
}
