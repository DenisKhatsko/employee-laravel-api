<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\select;


class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'age',
        'country',
        'email',
        'salary',
        'position',
    ];


    public static function getWithWeatherCode():Collection
    {
        return Employee::query()->with('weather')->get();
    }

    public function weather(): HasOne
    {
        return $this->hasOne(Weather::class,'employee_id','id');
    }

    public static function getEmployeesWithHighestSalaryByCountry($country):Collection
    {

        $query = Employee::select('employees.*')
            ->leftJoin(DB::raw('(SELECT country, MAX(salary) AS max_salary FROM employees GROUP BY country) AS max_salaries'), function ($join) {
                $join->on('employees.country', '=', 'max_salaries.country')
                    ->on('employees.salary', '=', 'max_salaries.max_salary');
            })
            ->whereNotNull('max_salaries.country');

        if($country) {
            $query->where('employees.country', $country);
        }
        return $query->get();
    }

    public static function getEmployeesByPositon($position):Collection
    {
        return Employee::query()->where('position', $position)->get();
    }

    public static function getEmployeeById($id):Model|null
    {
        return Employee::query()->where('id', $id)->first();
    }

    public static function deleteRecord($id): void
    {
        Employee::query()->where('id', $id)->delete();
    }

    public static function findById($id): Model|null
    {

        return Employee::query()->where('id', $id)->first();
    }

    public static function getUniqueCountryNames(): Collection
    {
        return Employee::query()->select('country')->groupBy('country')->get();
    }

    public static function getEmployeeByCountry($country):Collection
    {
        return Employee::query()->where('country', $country)->get();
    }

}
