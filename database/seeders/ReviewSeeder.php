<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\Product;
use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ReviewSeeder extends Seeder
{
    /**
     * Seed the application's database with reviews.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        
        // Get all products and articles
        $products = Product::all();
        $articles = Article::all();

        // Seed 3 reviews for each product
        foreach ($products as $product) {
            for ($i = 0; $i < 3; $i++) {
                $review = Review::create([
                    'id_users' => User::inRandomOrder()->first()->id,  // Random user for each review
                    'rating' => $faker->numberBetween(1, 5),  // Random rating between 1 and 5
                    'date' => $faker->dateTimeThisYear(),
                    'text' => $faker->paragraph,  // Random review text
                    'id_products' => $product->id,
                    'id_articles' => 0,
                    'id_reviews' => 0,  // No parent review
                    'admin_reply' => $faker->boolean(30) ? $faker->paragraph : '',  // 30% chance to have admin reply
                ]);

                // Optionally, add a child review (a reply) to some reviews
                if ($faker->boolean(50)) {  // 50% chance to have a child review
                    Review::create([
                        'id_users' => User::inRandomOrder()->first()->id,
                        'rating' => $faker->numberBetween(1, 5),
                        'date' => $faker->dateTimeThisYear(),
                        'text' => $faker->paragraph,
                        'id_products' => $product->id,
                        'id_articles' => 0,
                        'id_reviews' => $review->id,  // Link as child review
                        'admin_reply' => '',  // Child review will not have an admin reply
                    ]);
                }
            }
        }

        // Seed 3 reviews for each article
        foreach ($articles as $article) {
            for ($i = 0; $i < 3; $i++) {
                $review = Review::create([
                    'id_users' => User::inRandomOrder()->first()->id,  // Random user for each review
                    'rating' => $faker->numberBetween(1, 5),  // Random rating between 1 and 5
                    'date' => $faker->dateTimeThisYear(),
                    'text' => $faker->paragraph,  // Random review text
                    'id_products' => 0,
                    'id_articles' => $article->id,
                    'id_reviews' => 0,  // No parent review
                    'admin_reply' => $faker->boolean(30) ? $faker->paragraph : '',  // 30% chance to have admin reply
                ]);

                // Optionally, add a child review (a reply) to some reviews
                if ($faker->boolean(50)) {  // 50% chance to have a child review
                    Review::create([
                        'id_users' => User::inRandomOrder()->first()->id,
                        'rating' => $faker->numberBetween(1, 5),
                        'date' => $faker->dateTimeThisYear(),
                        'text' => $faker->paragraph,
                        'id_products' => 0,
                        'id_articles' => $article->id,
                        'id_reviews' => $review->id,  // Link as child review
                        'admin_reply' => '',  // Child review will not have an admin reply
                    ]);
                }
            }
        }
    }
}
