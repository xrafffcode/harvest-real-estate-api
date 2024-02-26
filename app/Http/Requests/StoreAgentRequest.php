<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Str;

class StoreAgentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'slug' => 'required', 'max:255', 'string',
            'code' => 'required', 'max:255', 'alpha_num',
            'name' => 'required', 'max:255', 'string',
            'description' => 'required', 'max:255', 'string',
            'specialization' => 'required', 'max:255', 'string',
            'email' => 'required', 'max:255', 'email',
            'phone_number' => 'required', 'min:0', 'numeric',
            'facebook' => 'nullable', 'max:255', 'string',
            'twitter' => 'nullable', 'max:255', 'string',
            'instagram' => 'nullable', 'max:255', 'string',
            'linkedin' => 'nullable', 'max:255', 'string',
            'avatar' => 'nullable', 'max:255', 'string',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'code' => Str::upper(Str::random(10)),
            'slug' => Str::slug($this->name) . '-' . Str::random(6),
        ]);
    }
}
