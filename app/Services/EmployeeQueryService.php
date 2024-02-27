<?php

namespace App\Services;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EmployeeQueryService
{
    public static function getUniqueCountryNames(): Collection
    {
        return Employee::query()->select('country')->groupBy('country')->get();
    }

    public static function getEmployeeByCountry($country): Collection
    {
        return Employee::query()->where('country', $country)->get();
    }

    public function getEmployeesByPosition($position): Collection
    {
        return Employee::query()->where('position', $position)->get();
    }

    public function getEmployeeById($id): ?Model
    {
        return Employee::query()->where('id', $id)->first();
    }

    public function getEmployeesWithHighestSalaryByCountry($country): Collection
    {

        $query = Employee::query()->select('employees.*')
            ->leftJoin(DB::raw('(SELECT country, MAX(salary) AS max_salary FROM employees GROUP BY country) AS max_salaries'), function ($join) {
                $join->on('employees.country', '=', 'max_salaries.country')
                    ->on('employees.salary', '=', 'max_salaries.max_salary');
            })
            ->whereNotNull('max_salaries.country');

        if ($country) {
            $query->where('employees.country', $country);
        }

        return $query->get();
    }

    public static function getWithWeatherCode(): Collection
    {
        return Employee::query()->with('weather')->get();
    }

}
