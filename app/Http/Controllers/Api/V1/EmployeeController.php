<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\EmployeeRequest;
use App\Http\Resources\Api\EmployeeResource;
use App\Models\Employee;
use App\Models\Weather;
use App\Services\EmployeeQueryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;


class EmployeeController extends Controller
{
    const TTL = 60 * 60 * 24;
    private int $limit = 500;

    private int $offset = 0;

    public function __construct(private readonly EmployeeQueryService $employeeQueryService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResource
    {
        if ($request->has('offset')) {
            $offset = (int) $request->get('offset');
            $this->offset = ($offset > 0) ? $offset : 0;
        }
        if ($request->has('limit')) {
            $limit = (int) $request->get('limit');
            $this->limit = ($limit > 0 && $limit < $this->limit) ? $limit : $this->limit;
        }
        return EmployeeResource::collection(Cache::remember('employees'.'offset='.$this->offset.'limit='.$this->limit,
            self::TTL, function () {

            return Employee::query()->offset($this->offset)->limit($this->limit)->get();
        }));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeRequest $request): EmployeeResource
    {
        $employee = Employee::create($request->validated());

        return new EmployeeResource($employee);

    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee): JsonResource|JsonResponse
    {
        return new EmployeeResource($employee);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeRequest $request, Employee $employee): JsonResponse
    {
        $result = $employee->update($request->validated());
        if (! $result) {
            response()->not_found(400);
        }

        return (new EmployeeResource($employee))->response()->setStatusCode(202);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        if (! Employee::find($id)) {

            return response()->not_found();
        }
        if ($weather = Weather::query()->where('employee_id', $id)) {
            $weather->delete();
        }

        Employee::query()->where('id', $id)->delete();

        return response()->success([], 202);
    }

    /**
     * Getting employees with the highest salary by country. All countries, or by one country if in url
     */
    public function highestSalaryByCountry($country = null): JsonResponse|AnonymousResourceCollection
    {
        $employee = $this->employeeQueryService->getEmployeesWithHighestSalaryByCountry($country);

        if ($employee->isEmpty()) {
            return response()->not_found();
        }

        return EmployeeResource::collection($employee);

    }

    /**
     * Getting employees list by position name requested.
     */
    public function employeeByPosition($position): JsonResponse|AnonymousResourceCollection
    {
        $employee = $this->employeeQueryService->getEmployeesByPosition($position);

        if ($employee->isEmpty()) {
            return response()->not_found();
        }

        return EmployeeResource::collection($employee);

    }


}
