<?php

namespace App\Providers;

use App\Models\Employee;
use App\Observers\EmployeeObserver;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Services\WeatherNotificationInterface::class,
            \App\Action\WeatherEmailNotificationAction::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();
        Employee::observe(EmployeeObserver::class);
    }
}
