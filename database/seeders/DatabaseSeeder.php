<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Http\Controllers\FrontEnd\UserController;
use App\Models\Category;
use App\Models\Sting;
use App\Models\StingCategory;
use App\Models\TransactionSting;
use App\Models\User;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    { 

        $this->call(CategorySeeder::class);
        $this->call(UserSeeder::class);
        //seed sting
        // Sting::factory(10)->create();
        Sting::create([
            "ID_STING" => "S_0000001",
            "DESKRIPSI" => "saya akan mengubah applikasi dari kotlin ke fluter",
            "TITLE_STING" => "Mengubah Bahasa Aplikasi",
            "EMAIL_BEEWORKER" => "enricoadi49@gmail.com",
            "NAMA_THUMBNAIL" => "S_0000001.png",
            "RATING" => 4,
            "DESKRIPSI_BASIC" => "akan selesai dalam waktu 2 minggu",
            "DESKRIPSI_PREMIUM" => "akan selesai dalam 3 - 7 hari",
            "PRICE_BASIC" => 100000,
            "PRICE_PREMIUM" => 250000,
            "MAX_REVISION_BASIC" => 1,
            "MAX_REVISION_PREMIUM" => 3,
            "STATUS" => 1
        ]);
        Sting::create([
            "ID_STING" => "S_0000002",
            "DESKRIPSI" => "saya akan mengedit video menggunakan premier pro",
            "TITLE_STING" => "Mengedit Video",
            "EMAIL_BEEWORKER" => "enricoadi49@gmail.com",
            "NAMA_THUMBNAIL" => "S_0000002.png",
            "RATING" => 5,
            "DESKRIPSI_BASIC" => "akan selesai dalam waktu 2 minggu",
            "DESKRIPSI_PREMIUM" => "akan selesai dalam 3 - 7 hari",
            "PRICE_BASIC" => 300000,
            "PRICE_PREMIUM" => 550000,
            "MAX_REVISION_BASIC" => 1,
            "MAX_REVISION_PREMIUM" => 3,
            "STATUS" => 1
        ]);
        Sting::create([
            "ID_STING" => "S_0000003",
            "DESKRIPSI" => "saya akan membuat ilustrasi dari deskripsi anda",
            "TITLE_STING" => "Membuat ilustrasi",
            "EMAIL_BEEWORKER" => "enricoadi49@gmail.com",
            "NAMA_THUMBNAIL" => "S_0000003.png",
            "RATING" => 4,
            "DESKRIPSI_BASIC" => "akan selesai dalam waktu 2 minggu",
            "DESKRIPSI_PREMIUM" => "akan selesai dalam 3 - 7 hari",
            "PRICE_BASIC" => 50000,
            "PRICE_PREMIUM" => 150000,
            "MAX_REVISION_BASIC" => 1,
            "MAX_REVISION_PREMIUM" => 3,
            "STATUS" => 1
        ]);
        Sting::create([
            "ID_STING" => "S_0000004",
            "DESKRIPSI" => "saya akan menganimasi dan mengisi suara dari script anda",
            "TITLE_STING" => "Membuat ilustrasi dan isi suara",
            "EMAIL_BEEWORKER" => "enricoadi49@gmail.com",
            "NAMA_THUMBNAIL" => "S_0000004.png",
            "RATING" => 5,
            "DESKRIPSI_BASIC" => "akan selesai dalam waktu 1 bulan",
            "DESKRIPSI_PREMIUM" => "akan selesai dalam 1 - 2 minggu",
            "PRICE_BASIC" => 850000,
            "PRICE_PREMIUM" => 1500000,
            "MAX_REVISION_BASIC" => 1,
            "MAX_REVISION_PREMIUM" => 3,
            "STATUS" => 1
        ]);
        Sting::create([
            "ID_STING" => "S_0000005",
            "DESKRIPSI" => "saya akan membuatkan dan mengedit cv atau dokumen lainya",
            "TITLE_STING" => "document writer, editor",
            "EMAIL_BEEWORKER" => "enricoadi49@gmail.com",
            "NAMA_THUMBNAIL" => "S_0000005.png",
            "RATING" => 4,
            "DESKRIPSI_BASIC" => "akan selesai dalam waktu 2 minggu",
            "DESKRIPSI_PREMIUM" => "akan selesai dalam 3 - 7 hari",
            "PRICE_BASIC" => 100000,
            "PRICE_PREMIUM" => 150000,
            "MAX_REVISION_BASIC" => 1,
            "MAX_REVISION_PREMIUM" => 3,
            "STATUS" => 1
        ]);

        StingCategory::create([
            "ID_STINGCATEGORY" => "1",
            "ID_STING" => "S_0000001",
            "ID_CATEGORY" => 1
        ]);
        StingCategory::create([
            "ID_STINGCATEGORY" => "2",
            "ID_STING" => "S_0000002",
            "ID_CATEGORY" => 2
        ]);
        StingCategory::create([
            "ID_STINGCATEGORY" => "3",
            "ID_STING" => "S_0000003",
            "ID_CATEGORY" => 5
        ]);
        StingCategory::create([
            "ID_STINGCATEGORY" => "4",
            "ID_STING" => "S_0000003",
            "ID_CATEGORY" => 2
        ]);
        StingCategory::create([
            "ID_STINGCATEGORY" => "5",
            "ID_STING" => "S_0000004",
            "ID_CATEGORY" => 4
        ]);
        StingCategory::create([
            "ID_STINGCATEGORY" => "6",
            "ID_STING" => "S_0000004",
            "ID_CATEGORY" => 5
        ]);
        StingCategory::create([
            "ID_STINGCATEGORY" => "7",
            "ID_STING" => "S_0000005",
            "ID_CATEGORY" => 2
        ]);
        StingCategory::create([
            "ID_STINGCATEGORY" => "8",
            "ID_STING" => "S_0000005",
            "ID_CATEGORY" => 3
        ]);

        TransactionSting::create([
            "ID_TRANSACTION" => "T_0005821",
            "ID_STING" => "S_0000003",
            "EMAIL_FARMER" => "jonathanbryanbuyer@gmail.com",
            "REQUIREMENT_PROJECT" => "Ilustrasi Superman",
            "DATE_START" => "2016-05-18 20:58:22",
            "DATE_END" => "2017-07-28 11:24:34",
            "STATUS" => 3,
            "IS_PREMIUM" => 1,
            "COMMISION" => 150000.00,
            "TAX" => 15000.00,
            "FILENAME_FINAL" => "T_0005821.jpg",
            "RATE" => 5,
            "REVIEW" => "Mantap",
            "JUMLAH_REVISI" => 0,
        ]);
        TransactionSting::create([
            "ID_TRANSACTION" => "T_0006730",
            "ID_STING" => "S_0000005",
            "EMAIL_FARMER" => "enricoadibuyer@gmail.com",
            "REQUIREMENT_PROJECT" => "Proposal Beli Rumah",
            "DATE_START" => null,
            "DATE_END" => null,
            "STATUS" => 0,
            "IS_PREMIUM" => 0,
            "COMMISION" => 100000.00,
            "TAX" => 10000.00,
            "FILENAME_FINAL" => "",
            "RATE" => 0,
            "REVIEW" => "",
            "JUMLAH_REVISI" => 0,
        ]);

        //seed category sting
        // StingCategory::factory(10)->create();
        //seed transaction sting
        // TransactionSting::factory(10)->create();
    }
}
