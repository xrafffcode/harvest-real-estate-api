<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'loc_city' => $this->loc_city,
            'loc_latitude' => $this->loc_latitude,
            'loc_longitude' => $this->loc_longitude,
            'loc_address' => $this->loc_address,
            'loc_state' => $this->loc_state,
            'loc_zip' => $this->loc_zip,
            'loc_country' => $this->loc_country,
            'price' => $this->price,
            'price_label' => $this->price_label,
            'agent_id' => $this->agent_id,
            'agent' => $this->agent,
            'is_featured' => $this->is_featured,
            'is_active' => $this->is_active,
            'is_sold' => $this->is_sold,
            'is_rented' => $this->is_rented,
            'offer_type' => $this->offer_type,
            'property_amenities' => PropertyAmenityResource::collection($this->propertyAmenities),
            'property_types' => PropertyTypeResource::collection($this->propertyTypes),
            'property_categories' => PropertyCategoryResource::collection($this->propertyCategories),
            'property_images' => PropertyImageResource::collection($this->propertyImages),
            'first_image' => PropertyImageResource::make($this->propertyImages->first()),
            'property_floor_plans' => FloorPlanResource::collection($this->floorPlans),
        ];
    }
}
