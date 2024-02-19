<?php

namespace App\Http\Controllers\Api;

use App\Action\DownloadEmployeePdfAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\EmployeeRequest;
use App\Http\Resources\Api\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;


class EmployeeController extends Controller
{

    private int $limit = 500;
    private int $offset = 0;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request):JsonResource
    {
        if ($request->has('offset')) {
            $offset = (int)$request->get('offset');
            $this->offset = ($offset > 0) ? $offset : 0;
        }
        if ($request->has('limit')) {
            $limit = (int)$request->get('limit');
            $this->limit = ($limit > 0 && $limit < 500) ? $limit : $this->limit;
        }

        if (Cache::has('employees'. $this->offset . $this->limit)) {

            return EmployeeResource::collection(Cache::get('employees'. $this->offset . $this->limit));
        }
        try {
            $qb = Employee::query();

            $qb->offset($this->offset)->limit($this->limit);
            $employees = $qb->get();

        } catch (\Exception $e) {
            Log::channel('api')->error($e->getMessage());
        }
        return EmployeeResource::collection(Cache::remember('employees'. $this->offset . $this->limit,60*60*24, function() use ($employees) {
            return $employees;
        }) );

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeRequest $request)
    {

        $validated = $request->validated();
        $employee = null;
        try {
            $employee = Employee::create($validated);
        } catch (\Exception $e) {
            Log::channel('api')->error($e->getMessage());
        }
        return response()->json($employee, $employee ? 201 : 400);

    }

    /**
     * Display the specified resource.
     */
    public function show($id):JsonResource|JsonResponse
    {
        $employee = null;
        try {
            $employee = Employee::findById($id);

        } catch (\Exception $e) {
            Log::channel('api')->error($e->getMessage());

        }

        return response()->json($employee, $employee ? 200 : 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeRequest $request, Employee $employee): JsonResponse
    {
        $validated = $request->validated();
        $result = false;
        try {
            $result = $employee->update($validated);
        } catch (\Exception $e) {
            Log::channel('api')->error($e->getMessage());
        }

        return response()->json($employee, $result ? 202 : 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        if (!Employee::find($id)) {
            return response()->json([], 404);
        }
        try {
            Employee::deleteRecord($id);
        } catch (\Exception $e) {
            Log::channel('api')->error($e->getMessage());
        }
        return response()->json([], 202);
    }

    /**
     * Getting employees with the highest salary by country. All countries, or by one country if in url
     */
    public function highestSalaryByCountry($country = null): JsonResponse|AnonymousResourceCollection
    {
        $employee = null;

        try {
            $employee = Employee::getEmployeesWithHighestSalaryByCountry($country);
        } catch (\Exception $e) {

            Log::channel('api')->error($e->getMessage());
        }
        if ($employee->isEmpty()) {
            return response()->json([], 404);
        }

        return EmployeeResource::collection($employee);

    }

    /**
     * Getting employees list by position name requested.
     */
    public function employeeByPosition($position): JsonResponse|AnonymousResourceCollection
    {
        $employee = null;
        try {
            $employee = Employee::getEmployeesByPositon($position);
        } catch (\Exception $e) {
            Log::channel('api')->error($e->getMessage());
        }

        if ($employee->isEmpty()) {
            return response()->json([], 404);
        }

        return EmployeeResource::collection($employee);

    }

    /**
     * Generate PDF profile file for employee requested by ID.
     */
    public function employeePdf($id): Response|JsonResponse
    {
        $employee = null;
        try {
            $employee = Employee::getEmployeeById($id);
        } catch (\Exception $e) {
            Log::channel('api')->error($e->getMessage());
        }

        if (is_null($employee)) {
            return response()->json([], 404);
        }

        return DownloadEmployeePdfAction::getPdf($employee);

    }

}
