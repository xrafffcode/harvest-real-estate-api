<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {
    Route::get('banners', [\App\Http\Controllers\Api\Admin\BannerController::class, 'index']);
    Route::get('banner/{banner}', [\App\Http\Controllers\Api\Admin\BannerController::class, 'show']);

    Route::get('web_configuration', [\App\Http\Controllers\Api\Admin\WebConfigurationController::class, 'index']);

    Route::get('agents', [\App\Http\Controllers\Api\Admin\AgentController::class, 'index']);
    Route::get('agent/{id}', [\App\Http\Controllers\Api\Admin\AgentController::class, 'show']);
    Route::get('agent/by-slug/{slug}', [\App\Http\Controllers\Api\Admin\AgentController::class, 'getAgentBySlug']);

    Route::get('property_types', [\App\Http\Controllers\Api\Admin\PropertyTypeController::class, 'index']);

    Route::get('property_amenities', [\App\Http\Controllers\Api\Admin\PropertyAmenityController::class, 'index']);
    Route::get('property_amenity/{property_amenity}', [\App\Http\Controllers\Api\Admin\PropertyAmenityController::class, 'show']);

    Route::get('property_categories', [\App\Http\Controllers\Api\Admin\PropertyCategoryController::class, 'index']);
    Route::get('property_category/{property_category}', [\App\Http\Controllers\Api\Admin\PropertyCategoryController::class, 'show']);

    Route::get('property_types', [\App\Http\Controllers\Api\Admin\PropertyTypeController::class, 'index']);
    Route::get('property_type/{property_type}', [\App\Http\Controllers\Api\Admin\PropertyTypeController::class, 'show']);

    Route::get('properties', [\App\Http\Controllers\Api\Admin\PropertyController::class, 'index']);
    Route::get('property/{property}', [\App\Http\Controllers\Api\Admin\PropertyController::class, 'show']);
    Route::get('property/by-slug/{slug}', [\App\Http\Controllers\Api\Admin\PropertyController::class, 'getPropertyBySlug']);

    Route::get('properties/search', [\App\Http\Controllers\Api\Admin\PropertyController::class, 'getPropertiesByParams']);
    Route::get('properties/cities', [\App\Http\Controllers\Api\Admin\PropertyController::class, 'getPropertyCities']);

    Route::get('floor_plans', [\App\Http\Controllers\Api\Admin\FloorPlanController::class, 'index']);
    Route::get('floor_plan/{floor_plan}', [\App\Http\Controllers\Api\Admin\FloorPlanController::class, 'show']);

    Route::get('testimonials', [\App\Http\Controllers\Api\Admin\TestimonialController::class, 'index']);
    Route::get('testimonial/{testimonial}', [\App\Http\Controllers\Api\Admin\TestimonialController::class, 'show']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('banner', [\App\Http\Controllers\Api\Admin\BannerController::class, 'store']);
        Route::post('banner/{banner}', [\App\Http\Controllers\Api\Admin\BannerController::class, 'update']);
        Route::delete('banner/{banner}', [\App\Http\Controllers\Api\Admin\BannerController::class, 'destroy']);

        Route::post('web_configuration', [\App\Http\Controllers\Api\Admin\WebConfigurationController::class, 'update']);

        Route::post('agent', [\App\Http\Controllers\Api\Admin\AgentController::class, 'store']);
        Route::post('agent/{agent}', [\App\Http\Controllers\Api\Admin\AgentController::class, 'update']);
        Route::delete('agent/{agent}', [\App\Http\Controllers\Api\Admin\AgentController::class, 'destroy']);

        Route::post('property_type', [\App\Http\Controllers\Api\Admin\PropertyTypeController::class, 'store']);
        Route::post('property_type/{property_type}', [\App\Http\Controllers\Api\Admin\PropertyTypeController::class, 'update']);
        Route::delete('property_type/{property_type}', [\App\Http\Controllers\Api\Admin\PropertyTypeController::class, 'destroy']);


        Route::post('property_amenity', [\App\Http\Controllers\Api\Admin\PropertyAmenityController::class, 'store']);
        Route::post('property_amenity/{property_amenity}', [\App\Http\Controllers\Api\Admin\PropertyAmenityController::class, 'update']);
        Route::delete('property_amenity/{property_amenity}', [\App\Http\Controllers\Api\Admin\PropertyAmenityController::class, 'destroy']);

        Route::post('property_category', [\App\Http\Controllers\Api\Admin\PropertyCategoryController::class, 'store']);
        Route::post('property_category/{property_category}', [\App\Http\Controllers\Api\Admin\PropertyCategoryController::class, 'update']);
        Route::delete('property_category/{property_category}', [\App\Http\Controllers\Api\Admin\PropertyCategoryController::class, 'destroy']);

        Route::post('property_type', [\App\Http\Controllers\Api\Admin\PropertyTypeController::class, 'store']);
        Route::put('property_type/{property_type}', [\App\Http\Controllers\Api\Admin\PropertyTypeController::class, 'update']);
        Route::delete('property_type/{property_type}', [\App\Http\Controllers\Api\Admin\PropertyTypeController::class, 'destroy']);

        Route::post('property', [\App\Http\Controllers\Api\Admin\PropertyController::class, 'store']);
        Route::post('property/{property}', [\App\Http\Controllers\Api\Admin\PropertyController::class, 'update']);
        Route::post('property/{property}/featured', [\App\Http\Controllers\Api\Admin\PropertyController::class, 'updateFeaturedProperty']);
        Route::post('property/{property}/active', [\App\Http\Controllers\Api\Admin\PropertyController::class, 'updateActiveProperty']);
        Route::post('property/{property}/sold', [\App\Http\Controllers\Api\Admin\PropertyController::class, 'updateSoldProperty']);
        Route::post('property/{property}/rented', [\App\Http\Controllers\Api\Admin\PropertyController::class, 'updateRentedProperty']);
        Route::delete('property/{property}', [\App\Http\Controllers\Api\Admin\PropertyController::class, 'destroy']);
        Route::delete('property/image/{image}', [\App\Http\Controllers\Api\Admin\PropertyController::class, 'deletePropertyImage']);

        Route::post('floor_plan', [\App\Http\Controllers\Api\Admin\FloorPlanController::class, 'store']);
        Route::post('floor_plan/{floor_plan}', [\App\Http\Controllers\Api\Admin\FloorPlanController::class, 'update']);
        Route::delete('floor_plan/{floor_plan}', [\App\Http\Controllers\Api\Admin\FloorPlanController::class, 'destroy']);

        Route::post('testimonial', [\App\Http\Controllers\Api\Admin\TestimonialController::class, 'store']);
        Route::post('testimonial/{testimonial}', [\App\Http\Controllers\Api\Admin\TestimonialController::class, 'update']);
        Route::delete('testimonial/{testimonial}', [\App\Http\Controllers\Api\Admin\TestimonialController::class, 'destroy']);

        Route::get('me', function () {
            return auth()->user();
        });

        Route::post('logout', [\App\Http\Controllers\Api\Auth\LoginController::class, 'logout']);
    });

    Route::post('login', [\App\Http\Controllers\Api\Auth\LoginController::class, 'login']);
});
