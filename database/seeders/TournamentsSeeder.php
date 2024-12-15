<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TournamentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 5; $i++) {
            // Generate random tournament data
            $title = $faker->sentence(4);
            $slug = Str::slug($title);
            $description = $faker->paragraph(3);
            $date = Carbon::now()->subDays(rand(1, 365));
            $metaTitle = $faker->sentence(6);
            $metaDescription = $faker->sentence(10);
            $metaKeywords = implode(',', $faker->words(5));

            // Insert data into tournaments_uk table
            DB::table('tournaments_uk')->insert([
                'title' => $title,
                'slug' => $slug,
                'description' => $description,
                'date' => $date,
                'meta_title' => $metaTitle,
                'meta_description' => $metaDescription,
                'meta_keywords' => $metaKeywords,
            ]);

            // Insert data into tournaments_en table
            DB::table('tournaments_en')->insert([
                'title' => $title,
                'slug' => $slug,
                'description' => $description,
                'date' => $date,
                'meta_title' => $metaTitle,
                'meta_description' => $metaDescription,
                'meta_keywords' => $metaKeywords,
            ]);
        }
    }
}
