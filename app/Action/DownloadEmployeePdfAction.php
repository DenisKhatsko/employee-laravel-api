<?php

namespace App\Action;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class DownloadEmployeePdfAction
{
    public static function getPdf($employee): Response
    {
        $pdf = Pdf::loadView('employee', compact('employee'));
        return $pdf->download('employee-'.$employee->id.'.pdf');

    }
}
