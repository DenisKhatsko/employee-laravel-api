<?php

namespace App\Enum;

enum WeatherConditions: int
{
    case THUNDERSTORM = 2;

    case DRIZZLE = 3;

    case RAIN = 5;

    case SNOW = 6;

    case ATMOSPHERE = 7;

    case CLEAR = 8;

    case CLOUDS = 9;

    public static function getRecomendationsByCode($code): string
    {
        $codeGroup = (int) substr($code, 0, 1);

        return match ($codeGroup) {
            self::THUNDERSTORM->value => 'Better to stay home',
            self::DRIZZLE->value => 'Keep warm, it`s drizzle',
            self::RAIN->value => 'Better to take an umbrella',
            self::SNOW->value => 'Don`t forget warm gloves and scarf',
            self::ATMOSPHERE->value => 'Nothing special',
            self::CLEAR->value => 'Probably you`ll see a sun today, take glasses',
            self::CLOUDS->value => 'No matter what you do, coffee get goes with you',
            default => '',
        };

    }
}
