<?php

namespace App\Http\Resources;

use App\Models\PropertyAmenity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyAmenityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $propertyCount = PropertyAmenity::find($this->id)->properties->count();

        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'status' => $this->status,
            'properties_count' => $propertyCount,
        ];
    }
}
