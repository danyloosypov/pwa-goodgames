<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ArticlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Get all tag and category ids to randomly assign to articles
        $tagIds = DB::table('article_tags_en')->pluck('id')->toArray();
        $categoryIds = DB::table('article_categories_en')->pluck('id')->toArray();

        // Predefined images
        $images = [
            'post-1-mid-square.jpg',
            'post-2-mid-square.jpg',
            'post-3-mid-square.jpg',
            'post-4-mid-square.jpg',
            'post-5-mid-square.jpg',
            'post-6-mid-square.jpg',
            'post-7-mid-square.jpg',
            'post-8-mid-square.jpg',
            'post-9-mid-square.jpg',
        ];

        for ($i = 0; $i < 100; $i++) {
            // Create random article data
            $title = $faker->sentence(6);
            $slug = Str::slug($title);
            $date = Carbon::now()->subDays(rand(1, 365));
            $excerpt = $faker->paragraph(2);
            $image = '/images/' . $faker->randomElement($images);
            $content = $faker->paragraphs(5, true);
            $metaTitle = $faker->sentence(6);
            $metaDescription = $faker->sentence(10);
            $metaKeywords = implode(',', $faker->words(5));

            // Insert data into articles_uk table
            DB::table('articles_uk')->insert([
                'title' => $title,
                'slug' => $slug,
                'date' => $date,
                'excerpt' => $excerpt,
                'image' => $image,
                'id_article_tags' => $faker->randomElement($tagIds),
                'id_article_categories' => $faker->randomElement($categoryIds),
                'content' => $content,
                'is_show' => 1,
                'meta_title' => $metaTitle,
                'meta_description' => $metaDescription,
                'meta_keywords' => $metaKeywords,
            ]);

            // Insert data into articles_en table
            DB::table('articles_en')->insert([
                'title' => $title,
                'slug' => $slug,
                'date' => $date,
                'excerpt' => $excerpt,
                'image' => $image,
                'id_article_tags' => $faker->randomElement($tagIds),
                'id_article_categories' => $faker->randomElement($categoryIds),
                'content' => $content,
                'is_show' => 1,
                'meta_title' => $metaTitle,
                'meta_description' => $metaDescription,
                'meta_keywords' => $metaKeywords,
            ]);
        }
    }
}
