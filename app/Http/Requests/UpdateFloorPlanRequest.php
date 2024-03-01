<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFloorPlanRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'property_id' => 'required|max:255|string|exists:properties,id',
            'sort' => 'required|integer',
            'title' => 'required|max:255|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    protected function prepareForValidation(): void
    {

    }
}
