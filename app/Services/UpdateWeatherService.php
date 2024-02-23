<?php

namespace App\Services;

use App\Action\WeatherApiAction;
use App\Dto\WeatherDto;
use App\Models\Employee;
use App\Models\Weather;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class UpdateWeatherService
{
    private Collection $countryList;

    public function __construct(
        protected WeatherApiAction $weatherApiAction,
        private readonly WeatherDto $weatherDto)
    {
    }

    public function handle():void
    {
        $this->countryList = EmployeeQueryService::getUniqueCountryNames();

        $weatherData =  $this->weatherApiAction->getData($this->countryList);

        $this->transformData($weatherData);

        $this->updateEmployeeWeatherData();

    }

    private function transformData(array $weatherData):void
    {
        foreach ($weatherData as $country => $data) {

            $this->weatherDto->setWeatherToCountry($country, $data);
        }
    }

    private function updateEmployeeWeatherData(): void
    {
        $data = [];
        foreach ($this->countryList as $country) {

            $employees = EmployeeQueryService::getEmployeeByCountry($country->country);
            $countryWeatherCode = $this->weatherDto->getWeatherCodeByCountry($country->country);

            foreach ($employees as $employee) {
                $data[] = ['employee_id' => $employee->id, 'code' => $countryWeatherCode];

            }

        }
        Weather::updateEmployeeWeatherCode($data);
    }
}
