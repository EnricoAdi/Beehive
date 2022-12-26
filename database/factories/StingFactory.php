<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sting>
 */
class StingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [

            "ID_STING" => "S_".(str_pad(rand(1,100000),7,'0',STR_PAD_LEFT)),
            "DESKRIPSI" => fake()->sentence(),
            "TITLE_STING" => fake()->sentence(),
            "EMAIL_BEEWORKER" => User::all()->random()->EMAIL,
            "NAMA_THUMBNAIL" => "default.jpg",
            "RATING" => 3,
            "DESKRIPSI_BASIC" => fake()->paragraph(),
            "DESKRIPSI_PREMIUM" => fake()->paragraph(),
            "PRICE_BASIC" => rand(100000,500000),
            "PRICE_PREMIUM" => rand(500000,700000),
            "MAX_REVISION_BASIC" => rand(1,3),
            "MAX_REVISION_PREMIUM" => rand(2,5),
            "STATUS" => rand(0,1),
        ];
    }
}
