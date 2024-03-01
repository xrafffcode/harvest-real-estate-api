<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WebConfigurationResource extends JsonResource
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
            'description' => $this->description,
            'email' => $this->email,
            'phone' => $this->phone,
            'logo' => $this->logo,
            'logo_url' => $this->logo ? asset('storage/'.$this->logo) : '',
            'map' => $this->map,
            'address' => $this->address,
            'facebook' => $this->facebook ? $this->facebook : '',
            'instagram' => $this->instagram ? $this->instagram : '',
            'youtube' => $this->youtube ? $this->youtube : '',
        ];
    }
}
