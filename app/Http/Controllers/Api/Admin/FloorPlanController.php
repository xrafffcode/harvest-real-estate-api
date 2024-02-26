<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFloorPlanRequest;
use App\Http\Requests\UpdateFloorPlanRequest;
use App\Http\Resources\FloorPlanResource;
use App\Interfaces\FloorPlanRepositoryInterface;

class FloorPlanController extends Controller
{
    private FloorPlanRepositoryInterface $floorPlanRepository;

    public function __construct(FloorPlanRepositoryInterface $floorPlanRepository)
    {
        $this->floorPlanRepository = $floorPlanRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $floorPlans = $this->floorPlanRepository->getAllFloorPlans();

            return ResponseHelper::jsonResponse(true, 'Floor Plans retrieved successfully', FloorPlanResource::collection($floorPlans), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFloorPlanRequest $request)
    {
        try {
            $floorPlans = $this->floorPlanRepository->createFloorPlan($request->all());

            return ResponseHelper::jsonResponse(true, 'Floor Plans created successfully', new FloorPlanResource($floorPlans), 201);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $floorPlan = $this->floorPlanRepository->getFloorPlanById($id);

            if (! $floorPlan) {
                return ResponseHelper::jsonResponse(false, 'FloorPlan not found', [], 404);
            }

            return ResponseHelper::jsonResponse(true, 'FloorPlan retrieved successfully', new FloorPlanResource($floorPlan), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFloorPlanRequest $request, string $id)
    {
        try {
            $floorPlans = $this->floorPlanRepository->updateFloorPlan($request->all(), $id);

            return ResponseHelper::jsonResponse(true, 'Floor Plans updated successfully', FloorPlanResource::collection($floorPlans), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->floorPlanRepository->deleteFloorPlan($id);

            return ResponseHelper::jsonResponse(true, 'Floor Plans deleted successfully', [], 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }
}
