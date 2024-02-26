<?php

namespace App\Providers;

use App\Models\Employee;
use App\Observers\EmployeeObserver;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Response;
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
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();
        Employee::observe(EmployeeObserver::class);

        Response::macro('success', function ($data, $code = 200) {
            return response()->json($data, $code);
        });
        Response::macro('not_found', function ($code = 404) {
            return response()->json([], $code);
        });

    }
}
