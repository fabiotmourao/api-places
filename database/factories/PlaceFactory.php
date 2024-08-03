<?php

namespace Database\Factories;

use App\Models\Place;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlaceFactory extends Factory
{
    protected $model = Place::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'city' => $this->faker->city,
            'slug' => $this->faker->slug,
        ];
    }
}
