<?php

namespace App\Action;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;

class WeatherApiAction
{
    private string $key;

    private string $baseApiUrl = 'https://api.openweathermap.org/data/2.5/weather';

    private array $weatherRawData = [];

    public function __construct()
    {
        $this->key = config('app.weather_api.key');
    }

    public function getData($countryList): array
    {
        foreach ($countryList as $country) {
            try {
                $url = $this->baseApiUrl.'?q='.$country->country.'&appid='.$this->key;

                $response = Http::retry(2, 2000, null, false)
                    ->get($url);

                if (! $this->validateResponse($response)) {
                    Log::channel('single')->alert(json_encode($response->json()));

                }
                $this->weatherRawData[$country->country] = $response->json();
            } catch (HttpException $e) {

                Log::channel('single')->alert($e->getMessage());
            }
        }

        return $this->weatherRawData;

    }

    private function validateResponse(Response $response): bool
    {
        return $response->status() == 200;
    }
}
