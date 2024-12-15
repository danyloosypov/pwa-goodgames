<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class TeamsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Array of available logos
        $logos = ['team-1.jpg', 'team-2.jpg', 'team-3.jpg', 'team-4.jpg'];

        for ($i = 0; $i < 10; $i++) {
            // Generate random team data
            $title = $faker->company;
            $slug = Str::slug($title);
            $description = $faker->paragraph(3);
            $logo = '/images/' . $logos[array_rand($logos)]; // Randomly choose a logo
            $metaTitle = $faker->sentence(6);
            $metaDescription = $faker->sentence(10);
            $metaKeywords = implode(',', $faker->words(5));

            // Insert data into teams_uk table
            DB::table('teams_uk')->insert([
                'title' => $title,
                'slug' => $slug,
                'logo' => $logo,
                'description' => $description,
                'team_photo' => '/images/team-photo.png',
                'meta_title' => $metaTitle,
                'meta_description' => $metaDescription,
                'meta_keywords' => $metaKeywords,
            ]);

            // Insert data into teams_en table
            DB::table('teams_en')->insert([
                'title' => $title,
                'slug' => $slug,
                'logo' => $logo,
                'description' => $description,
                'team_photo' => 'team-photo.png',
                'meta_title' => $metaTitle,
                'meta_description' => $metaDescription,
                'meta_keywords' => $metaKeywords,
            ]);
        }
    }
}
