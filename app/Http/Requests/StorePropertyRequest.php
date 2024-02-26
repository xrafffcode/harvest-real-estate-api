<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Str;

class StorePropertyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required', 'max:255', 'string',
            'description' => 'required', 'max:255', 'string',
            'loc_city' => 'required', 'max:255', 'string',
            'loc_latitude' => 'required', 'max:255', 'string',
            'loc_longitude' => 'required', 'max:255', 'string',
            'loc_address' => 'required', 'max:255', 'string',
            'loc_state' => 'required', 'max:255', 'string',
            'loc_zip' => 'required', 'min:0', 'numeric',
            'loc_country' => 'required', 'max:255', 'string',
            'price' => 'required', 'min:0', 'numeric',
            'agent_id' => 'required', 'max:255', 'string', 'unique:agent',
        ];
    }
}
