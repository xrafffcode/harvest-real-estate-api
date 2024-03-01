<?php

namespace App\Http\Resources;

use App\Models\PropertyCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $propertyCount = PropertyCategory::find($this->id)->properties->count();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'icon' => $this->icon,
            'total_properties' => $propertyCount,
        ];
    }
}
