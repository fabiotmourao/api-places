<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PlaceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        error_log('PlaceRequest authorize method is being called');

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        error_log('PlaceRequest authorize method is being called');

        return [
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('places')->ignore($this->place),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'city.required' => 'The city field is required.',
            'city.max' => 'The city may not be greater than 255 characters.',
            'slug.max' => 'The slug may not be greater than 255 characters.',
            'slug.unique' => 'The provided slug already exists. Please choose a different slug.',
        ];
    }
}
