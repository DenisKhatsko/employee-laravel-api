<?php

namespace App\Http\Controllers\Api\V1;

use App\Action\DownloadEmployeePdfAction;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmployeePdfController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Employee $employee): Response|JsonResponse
    {
        return DownloadEmployeePdfAction::getPdf($employee);
    }
}
