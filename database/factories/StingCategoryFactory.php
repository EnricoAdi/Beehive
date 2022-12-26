<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Sting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StingCategory>
 */
class StingCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "ID_STING" => Sting::all()->random()->ID_STING,
            "ID_CATEGORY" => Category::all()->random()->ID_CATEGORY
        ];
    }
}
