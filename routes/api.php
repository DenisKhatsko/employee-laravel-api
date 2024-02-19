<?php

use App\Http\Controllers\Api\EmployeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::apiResource('employee',EmployeeController::class);
Route::get('/employee-top-salary/{country?}', [EmployeeController::class, 'highestSalaryByCountry']);
Route::get('/employee/position/{position}', [EmployeeController::class, 'employeeByPosition']);
Route::get('/employee-pdf/{id}',[EmployeeController::class, 'employeePdf']);