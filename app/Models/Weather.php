<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'description'];

    public function employee()
    {
        return $this->belongsTo(Employee::class,'employee_id');
    }

    public static function updateEmployeeWeatherCode($data):void
    {
       $res = Weather::query()->upsert($data, ['employee_id'], ['code']);

    }

}
