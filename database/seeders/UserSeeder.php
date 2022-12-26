<?php

namespace Database\Seeders;

use App\Http\Controllers\FrontEnd\UserController;
use App\Models\User;
use DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        date_default_timezone_set("Asia/Jakarta");
        $date = date("Y-m-d H:i:s");
        //seed user
        User::create([
            "EMAIL" => "enricoadi49@gmail.com",
            "PASSWORD" => bcrypt("enrico"),
            "NAMA" => "Enrico",
            "REMEMBER_TOKEN" => UserController::GenerateRandomToken(40),
            "STATUS" => 2,
            "TANGGAL_LAHIR" => new DateTime(),
            "BALANCE" => 5000000,
            "BIO" => "Sedang mencari nafkah",
            "RATING" => 4,
            "SUBSCRIBED" => rand(0,1),
            "PICTURE" => "default.jpg",
            "EMAIL_VERIFIED_AT" => $date
        ]);
        User::create([
            "EMAIL" => "jonathanbryan21@gmail.com",
            "PASSWORD" => bcrypt("jonathan"),
            "NAMA" => "Jonathan Bryan",
            "REMEMBER_TOKEN" => UserController::GenerateRandomToken(40),
            "STATUS" => 2,
            "TANGGAL_LAHIR" => new DateTime(),
            "BALANCE" => 5000,
            "BIO" => "Sedang mencari nafkah juga",
            "RATING" => 4,
            "SUBSCRIBED" => rand(0,1),
            "PICTURE" => "default.jpg",
            "EMAIL_VERIFIED_AT" => $date
        ]);
        User::create([
            "EMAIL" => "jonathanbryanbuyer@gmail.com",
            "PASSWORD" => bcrypt("jonathan"),
            "NAMA" => "Jonathan Bryan Tapi Buyer",
            "REMEMBER_TOKEN" => UserController::GenerateRandomToken(40),
            "STATUS" => 1,
            "TANGGAL_LAHIR" => new DateTime(),
            "BALANCE" => 5000,
            "BIO" => "Sedang mencari Tukang juga",
            "RATING" => 4,
            "SUBSCRIBED" => rand(0,1),
            "PICTURE" => "default.jpg",
            "EMAIL_VERIFIED_AT" => $date
        ]);
        User::create([
            "EMAIL" => "enricoadibuyer@gmail.com",
            "PASSWORD" => bcrypt("enrico"),
            "NAMA" => "Enrico",
            "REMEMBER_TOKEN" =>UserController::GenerateRandomToken(40),
            "STATUS" => 1,
            "TANGGAL_LAHIR" => new DateTime(),
            "BALANCE" => 5000000,
            "BIO" => "Sedang mencari tukang",
            "RATING" => 4,
            "SUBSCRIBED" => rand(0,1),
            "PICTURE" => "default.jpg",
            "EMAIL_VERIFIED_AT" => $date
        ]);
        User::create([
            "EMAIL" => "enricoadiadmin@gmail.com",
            "PASSWORD" => bcrypt("enrico"),
            "NAMA" => "Enrico",
            "REMEMBER_TOKEN" => UserController::GenerateRandomToken(40),
            "STATUS" => 3,
            "TANGGAL_LAHIR" => new DateTime(),
            "BALANCE" => 500,
            "BIO" => "Im a admin",
            "RATING" => 4,
            "SUBSCRIBED" => rand(0,1),
            "PICTURE" => "default.jpg",
            "EMAIL_VERIFIED_AT" => $date
        ]);
        User::factory(20)->create();
    }
}
