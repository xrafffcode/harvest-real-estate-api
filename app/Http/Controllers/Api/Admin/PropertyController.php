<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Http\Resources\PropertyResource;
use App\Interfaces\PropertyRepositoryInterface;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    private PropertyRepositoryInterface $propertyRepository;

    public function __construct(PropertyRepositoryInterface $propertyRepository)
    {
        $this->propertyRepository = $propertyRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $properties = $this->propertyRepository->getAllProperties($request->sortBy, $request->sort);

            return ResponseHelper::jsonResponse(true, 'Properties retrieved successfully', PropertyResource::collection($properties), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }

    public function getPropertiesByParams(Request $request)
    {
        try {
            $properties = $this->propertyRepository->getPropertiesByParams($request->search, $request->city, $request->category, $request->amenities, $request->type, $request->minPrice, $request->maxPrice, $request->sold, $request->rented);

            return ResponseHelper::jsonResponse(true, 'Properties retrieved successfully', PropertyResource::collection($properties), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }

    public function getPropertyCities()
    {
        try {
            $cities = $this->propertyRepository->getPropertyCities();

            return ResponseHelper::jsonResponse(true, 'Cities retrieved successfully', $cities, 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePropertyRequest $request)
    {
        try {
            $properties = $this->propertyRepository->createProperty($request->all());

            return ResponseHelper::jsonResponse(true, 'Properties created successfully', new PropertyResource($properties), 201);
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
            $property = $this->propertyRepository->getPropertyById($id);

            if (!$property) {
                return ResponseHelper::jsonResponse(false, 'Property not found', [], 404);
            }

            return ResponseHelper::jsonResponse(true, 'Property retrieved successfully', new PropertyResource($property), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePropertyRequest $request, string $id)
    {
        try {
            $properties = $this->propertyRepository->updateProperty($request->all(), $id);

            return ResponseHelper::jsonResponse(true, 'Properties updated successfully', [], 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }

    public function updateFeaturedProperty(Request $request, string $id)
    {
        try {
            $this->propertyRepository->updateFeaturedProperty($id, $request->is_featured);

            return ResponseHelper::jsonResponse(true, 'Properties updated successfully', [], 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }

    public function updateActiveProperty(Request $request, string $id)
    {
        try {
            $this->propertyRepository->updateActiveProperty($id, $request->is_active);

            return ResponseHelper::jsonResponse(true, 'Properties updated successfully', [], 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }

    public function updateSoldProperty(Request $request, string $id)
    {
        try {
            $this->propertyRepository->updateSoldProperty($id, $request->is_sold);

            return ResponseHelper::jsonResponse(true, 'Properties updated successfully', [], 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }

    public function updateRentedProperty(Request $request, string $id)
    {
        try {
            $this->propertyRepository->updateRentedProperty($id, $request->is_rented);

            return ResponseHelper::jsonResponse(true, 'Properties updated successfully', [], 200);
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
            $this->propertyRepository->deleteProperty($id);

            return ResponseHelper::jsonResponse(true, 'Properties deleted successfully', [], 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }

    public function getPropertyBySlug(string $slug)
    {
        try {
            $property = $this->propertyRepository->getPropertyBySlug($slug);

            if (!$property) {
                return ResponseHelper::jsonResponse(false, 'Property not found', [], 404);
            }

            return ResponseHelper::jsonResponse(true, 'Property retrieved successfully', new PropertyResource($property), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }

    public function deletePropertyImage(string $id)
    {
        try {
            $this->propertyRepository->deletePropertyImage($id);

            return ResponseHelper::jsonResponse(true, 'Property image deleted successfully', [], 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }
}
