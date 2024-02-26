<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePropertyAmenityRequest;
use App\Http\Requests\UpdatePropertyAmenityRequest;
use App\Http\Resources\PropertyAmenityResource;
use App\Interfaces\PropertyAmenityRepositoryInterface;

class PropertyAmenityController extends Controller
{
    private PropertyAmenityRepositoryInterface $propertyAmenitiesRepository;

    public function __construct(PropertyAmenityRepositoryInterface $propertyAmenitiesRepository)
    {
        $this->propertyAmenitiesRepository = $propertyAmenitiesRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $propertyAmenities = $this->propertyAmenitiesRepository->getAllPropertyAmenities();

            return ResponseHelper::jsonResponse(true, 'Property Amenities retrieved successfully', PropertyAmenityResource::collection($propertyAmenities), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePropertyAmenityRequest $request)
    {
        try {
            $propertyAmenities = $this->propertyAmenitiesRepository->createPropertyAmenity($request->all());

            return ResponseHelper::jsonResponse(true, 'Property Amenities created successfully', new PropertyAmenityResource($propertyAmenities), 201);
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
            $propertyAmenities = $this->propertyAmenitiesRepository->getPropertyAmenityById($id);

            if (!$propertyAmenities) {
                return ResponseHelper::jsonResponse(false, 'PropertyAmenity not found', [], 404);
            }

            return ResponseHelper::jsonResponse(true, 'PropertyAmenity retrieved successfully', new PropertyAmenityResource($propertyAmenities), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePropertyAmenityRequest $request, string $id)
    {
        try {
            $this->propertyAmenitiesRepository->updatePropertyAmenity($request->all(), $id);

            return ResponseHelper::jsonResponse(true, 'Property Amenities updated successfully', [], 200);
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
            $propertyAmenities = $this->propertyAmenitiesRepository->deletePropertyAmenity($id);

            return ResponseHelper::jsonResponse(true, 'Property Amenities deleted successfully', [], 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }
}
