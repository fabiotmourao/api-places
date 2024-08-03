<?php

namespace App\Validators;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class PlaceValidation
{
    public static function rules($id = null)
    {
        return [
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('places')->ignore($id),
            ],
        ];
    }

    public static function messages()
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

    public static function validate($data, $id = null)
    {
        return Validator::make($data, self::rules($id), self::messages());
    }
}
