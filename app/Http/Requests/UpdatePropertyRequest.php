<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePropertyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:255|string',
            'description' => 'required|max:255|string',
            'loc_city' => 'required|max:255|string',
            'loc_latitude' => 'required|max:255|string',
            'loc_longitude' => 'required|max:255|string',
            'loc_address' => 'required|max:255|string',
            'loc_state' => 'required|max:255|string',
            'loc_zip' => 'required|min:0|string',
            'loc_country' => 'required|max:255|string',
            'price' => 'required|min:0|numeric',
            'agent_id' => 'required|max:255|string|exists:agents,id',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'is_sold' => 'nullable|boolean',
            'is_rented' => 'nullable|boolean',
            'offer_type' => 'nullable|max:255|string',
            'slug' => 'nullable|max:255|string|unique:properties,slug,'.$this->route('property'),

            'property_amenities' => 'required|array',
            'property_amenities.*' => 'exists:property_amenities,id',

            'property_categories' => 'required|array',
            'property_categories.*' => 'exists:property_categories,id',

            'property_types' => 'required|array',
            'property_types.*' => 'exists:property_types,id',

            'property_images' => 'nullable|array',
            'property_images.*.id' => 'nullable|string|exists:property_images,id',
            'property_images.*.image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',

            'property_floor_plans' => 'nullable|array',
            'property_floor_plans.*.id' => 'nullable|string|exists:floor_plans,id',
            'property_floor_plans.*.sort' => 'required|integer',
            'property_floor_plans.*.title' => 'required|max:255|string',
            'property_floor_plans.*.image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    protected function prepareForValidation(): void
    {
        if (! $this->has('slug')) {
            $this->merge(['slug' => null]);
        }

        if ($this->has('property_images')) {
            $propertyImages = $this->property_images;
            foreach ($propertyImages as $index => $propertyImage) {
                if (! isset($propertyImage['id'])) {
                    $propertyImages[$index]['id'] = null;
                }
            }
            $this->merge(['property_images' => $propertyImages]);
        }

        if ($this->has('property_floor_plans')) {
            $propertyFloorPlans = $this->property_floor_plans;
            foreach ($propertyFloorPlans as $index => $propertyFloorPlan) {
                if (! isset($propertyFloorPlan['id'])) {
                    $propertyFloorPlans[$index]['id'] = null;
                }
            }
            $this->merge(['property_floor_plans' => $propertyFloorPlans]);
        }
    }
}
