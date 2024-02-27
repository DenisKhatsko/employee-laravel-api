<?php

namespace App\Services;

use App\Enum\WeatherConditions;

readonly class WeatherNotificationService
{
    public function __construct(private WeatherNotificationInterface $notification)
    {
    }

    public function handleNotification(): void
    {

        $employees = EmployeeQueryService::getWithWeatherCode();

        foreach ($employees as $employee) {
            $employeeWithWeatherRelation = $employee->find($employee->id);
            $employeeEmail = $employee->email;
            $weatherCode = $employeeWithWeatherRelation->weather->code;
            $message = WeatherConditions::getRecomendationsByCode($weatherCode);
            $this->notification->sendWeatherNotification($employeeEmail, $message);

        }

    }
}
