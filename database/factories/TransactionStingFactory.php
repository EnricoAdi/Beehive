<?php

namespace Database\Factories;

use App\Models\Sting;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransactionSting>
 */
class TransactionStingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "ID_TRANSACTION" => "T_".(str_pad(rand(1,100000),7,'0',STR_PAD_LEFT)),
            "ID_STING" => Sting::all()->random()->ID_STING,
            "EMAIL_FARMER" => User::all()->random()->EMAIL,
            "REQUIREMENT_PROJECT" => fake()->paragraph(),
            "DATE_START" => fake()->dateTimeThisDecade(),
            "DATE_END" => fake()->dateTimeThisDecade(),
            "STATUS" => rand(-2,4),
            "IS_PREMIUM" => rand(0,2),
            "COMMISION" => rand(100000,300000),
            "TAX" => rand(10000,30000),
            "FILENAME_FINAL" => fake()->firstName()."file.pdf",
            "RATE" => rand(1,4),
            "REVIEW" => fake()->paragraph(),
            "JUMLAH_REVISI" => rand(1,4) 
        ];
    }
}
