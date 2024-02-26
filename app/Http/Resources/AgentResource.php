<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AgentResource extends JsonResource
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
            'slug' => $this->slug,
            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,
            'specialization' => $this->specialization,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'facebook' => $this->facebook ?? '',
            'twitter' => $this->twitter ?? '',
            'instagram' => $this->instagram ?? '',
            'linkedin' => $this->linkedin ?? '',
            'avatar_url' => $this->avatar ? asset('storage/' . $this->avatar) : asset('images/avatar.jpg'),
            'properties' => $this->properties,
        ];
    }
}
