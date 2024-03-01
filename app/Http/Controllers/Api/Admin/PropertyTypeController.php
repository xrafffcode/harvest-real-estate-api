<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePropertyTypeRequest;
use App\Http\Requests\UpdatePropertyTypeRequest;
use App\Http\Resources\PropertyTypeResource;
use App\Interfaces\PropertyTypeRepositoryInterface;

class PropertyTypeController extends Controller
{
    private PropertyTypeRepositoryInterface $propertyTypeRepository;

    /**
     * PropertyTypeController constructor.
     */
    public function __construct(PropertyTypeRepositoryInterface $propertyTypeRepository)
    {
        $this->propertyTypeRepository = $propertyTypeRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $propertyTypes = $this->propertyTypeRepository->getAllPropertyTypes();

            return ResponseHelper::jsonResponse(true, 'Property types retrieved successfully', PropertyTypeResource::collection($propertyTypes), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePropertyTypeRequest $request)
    {
        $request = $request->validated();

        $slug = $request['slug'];
        if ($request['slug'] == '') {
            $tryCount = 1;
            do {
                $slug = $this->propertyTypeRepository->generateSlug($request['name'], $tryCount);
                $tryCount++;
            } while (! $this->propertyTypeRepository->isUniqueSlug($slug));
            $request['slug'] = $slug;
        }

        try {
            $propertyType = $this->propertyTypeRepository->create($request);

            return ResponseHelper::jsonResponse(true, 'Property type created successfully', new PropertyTypeResource($propertyType), 201);
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
            $propertyType = $this->propertyTypeRepository->getPropertyTypeById($id);

            return ResponseHelper::jsonResponse(true, 'Property type retrieved successfully', new PropertyTypeResource($propertyType), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePropertyTypeRequest $request, string $id)
    {
        $request = $request->validated();

        $slug = $request['slug'];
        if ($request['slug'] == '') {
            $tryCount = 1;
            do {
                $slug = $this->propertyTypeRepository->generateSlug($request['name'], $tryCount);
                $tryCount++;
            } while (! $this->propertyTypeRepository->isUniqueSlug($slug, $id));
            $request['slug'] = $slug;
        }

        try {
            $propertyType = $this->propertyTypeRepository->update($request, $id);

            return ResponseHelper::jsonResponse(true, 'Property type updated successfully', new PropertyTypeResource($propertyType), 200);
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
            $this->propertyTypeRepository->delete($id);

            return ResponseHelper::jsonResponse(true, 'Property type deleted successfully', [], 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }
}
