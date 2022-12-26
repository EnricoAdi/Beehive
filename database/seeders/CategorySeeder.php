<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //seed category
        $categories = [
            "Programming", "Editor", "Writer", "Voice Actor", "Illustrator",
            "Video Editing", "Logo Design", "Website Design", "Mobile UI Design",
            "Storyboard Creator", "Icon Design", "SEO", "Influencer Marketing", "Website Deployment",
            "User Testing", "Desktop Application", "Devops Development", "Cloud Engineering",
            "Chatbots", "Wordpress", "Online Music Lesson", "Audio Editing", "Songwriters",
            "Business Consulting", "Financial Consulting", "ERP Management", "Supply Chain Management", "Sales", "Online Course", "Content Creating", "Fashion Design"
        ];
        for ($i = 0; $i < sizeof($categories); $i++) {
            Category::create([
                // "ID_CATEGORY" => $i + 1,
                "NAMA_CATEGORY" => $categories[$i],
            ]);
        }
    }
}
