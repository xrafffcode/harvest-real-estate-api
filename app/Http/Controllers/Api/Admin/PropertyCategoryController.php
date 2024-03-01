<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePropertyCategoryRequest;
use App\Http\Requests\UpdatePropertyCategoryRequest;
use App\Http\Resources\PropertyCategoryResource;
use App\Interfaces\PropertyCategoryRepositoryInterface;

class PropertyCategoryController extends Controller
{
    private PropertyCategoryRepositoryInterface $propertyCategoryRepository;

    public function __construct(PropertyCategoryRepositoryInterface $propertyCategoryRepository)
    {
        $this->propertyCategoryRepository = $propertyCategoryRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $propertyCategories = $this->propertyCategoryRepository->getAllPropertyCategories();

            return ResponseHelper::jsonResponse(true, 'Property Categories retrieved successfully', PropertyCategoryResource::collection($propertyCategories), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePropertyCategoryRequest $request)
    {
        $request = $request->validated();

        $slug = $request['slug'];
        if ($request['slug'] == '') {
            $tryCount = 1;
            do {
                $slug = $this->propertyCategoryRepository->generateSlug($request['name'], $tryCount);
                $tryCount++;
            } while (! $this->propertyCategoryRepository->isUniqueSlug($slug));
            $request['slug'] = $slug;
        }

        try {
            $propertyCategory = $this->propertyCategoryRepository->create($request);

            return ResponseHelper::jsonResponse(true, 'Property Categories created successfully', new PropertyCategoryResource($propertyCategory), 201);
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
            $propertyCategory = $this->propertyCategoryRepository->getPropertyCategoryById($id);

            if (! $propertyCategory) {
                return ResponseHelper::jsonResponse(false, 'PropertyCategory not found', [], 404);
            }

            return ResponseHelper::jsonResponse(true, 'PropertyCategory retrieved successfully', new PropertyCategoryResource($propertyCategory), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePropertyCategoryRequest $request, string $id)
    {
        $request = $request->validated();

        $slug = $request['slug'];
        if ($request['slug'] == '') {
            $tryCount = 1;
            do {
                $slug = $this->propertyCategoryRepository->generateSlug($request['name'], $tryCount);
                $tryCount++;
            } while (! $this->propertyCategoryRepository->isUniqueSlug($slug, $id));
            $request['slug'] = $slug;
        }

        try {
            $propertyCategory = $this->propertyCategoryRepository->update($request, $id);

            return ResponseHelper::jsonResponse(true, 'Property Categories updated successfully', new PropertyCategoryResource($propertyCategory), 200);
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
            $this->propertyCategoryRepository->delete($id);

            return ResponseHelper::jsonResponse(true, 'Property Categories deleted successfully', [], 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }
}
