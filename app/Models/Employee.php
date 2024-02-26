<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function weather(): HasOne
    {
        return $this->hasOne(Weather::class, 'employee_id', 'id');
    }
}
