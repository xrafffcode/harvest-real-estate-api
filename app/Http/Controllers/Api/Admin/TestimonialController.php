<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTestimonialRequest;
use App\Http\Requests\UpdateTestimonialRequest;
use App\Http\Resources\TestimonialResource;
use App\Interfaces\TestimonialRepositoryInterface;

class TestimonialController extends Controller
{
    private TestimonialRepositoryInterface $testimonialRepository;

    public function __construct(TestimonialRepositoryInterface $testimonialRepository)
    {
        $this->testimonialRepository = $testimonialRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $testimonials = $this->testimonialRepository->getAllTestimonials();

            return ResponseHelper::jsonResponse(true, 'Testimonials retrieved successfully', TestimonialResource::collection($testimonials), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTestimonialRequest $request)
    {
        try {
            $testimonials = $this->testimonialRepository->createTestimonial($request->all());

            return ResponseHelper::jsonResponse(true, 'Testimonials created successfully', new TestimonialResource($testimonials), 201);
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
            $testimonial = $this->testimonialRepository->getTestimonialById($id);

            if (!$testimonial) {
                return ResponseHelper::jsonResponse(false, 'Testimonial not found', [], 404);
            }

            return ResponseHelper::jsonResponse(true, 'Testimonial retrieved successfully', new TestimonialResource($testimonial), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTestimonialRequest $request, string $id)
    {
        try {
            $testimonials = $this->testimonialRepository->updateTestimonial($request->all(), $id);

            return ResponseHelper::jsonResponse(true, 'Testimonials updated successfully', [], 200);
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
            $this->testimonialRepository->deleteTestimonial($id);

            return ResponseHelper::jsonResponse(true, 'Testimonials deleted successfully', [], 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }
}
