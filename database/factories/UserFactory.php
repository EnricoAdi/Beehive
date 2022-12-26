<?php

namespace Database\Factories;

use App\Http\Controllers\FrontEnd\UserController;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $s = fake()->unique()->name();
        $firstname = explode(" ",$s)[0];
        $uniquenumber = rand(1000,5500);
        $lastname = explode(" ",$s)[1];

        date_default_timezone_set("Asia/Jakarta");
        $date = date("Y-m-d H:i:s");

        return [
            // 'EMAIL' => Str::lower(fake()->firstName())."@gmail.com",
            'EMAIL' => Str::lower($firstname).$uniquenumber."@gmail.com",
            'PASSWORD' => bcrypt(Str::lower($firstname)), // password
            'NAMA' => $s,
            'REMEMBER_TOKEN' => UserController::GenerateRandomToken(40),
            'STATUS' => rand(-1,3),
            'TANGGAL_LAHIR' => fake()->dateTimeThisDecade(),
            'BALANCE' => 10000,
            'BIO' => "Is looking for ".fake()->colorName(),
            'RATING' => 4,
            // "PICTURE" => $firstname.".jpg",
            "PICTURE" => "default.jpg",
            "SUBSCRIBED" => rand(0,1),
            "EMAIL_VERIFIED_AT" => $date
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    // public function unverified()
    // {
    //     return $this->state(fn (array $attributes) => [
    //         'email_verified_at' => null,
    //     ]);
    // }
}
