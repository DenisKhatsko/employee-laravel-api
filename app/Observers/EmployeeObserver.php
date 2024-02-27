<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class EmployeeObserver
{
    /**
     * Handle the Employee "created" event.
     */
    public function created(): void
    {
        Cache::forget('employees');
    }

    /**
     * Handle the Employee "updated" event.
     */
    public function updated(): void
    {
        Cache::forget('employees');
    }

    /**
     * Handle the Employee "deleted" event.
     */
    public function deleted(): void
    {
        Cache::forget('employees');
    }
}
