<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Genre;
use App\Models\ProductCategory;
use App\Models\ProductTag;
use App\Models\Platform;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Loop to create 200 products
        for ($i = 0; $i < 200; $i++) {
            // Generate product data
            $title = $faker->word . ' ' . $faker->word;
            $slug = strtolower(str_replace(' ', '-', $title));
            $price = $faker->randomFloat(2, 10, 200); // Price between 10 and 200
            $old_price = $price + $faker->randomFloat(2, 5, 20); // Old price is higher than the current price
            $sku = strtoupper($faker->lexify('???') . $faker->numerify('###'));
            $excerpt = $faker->sentence;
            $release_date = $faker->dateTimeBetween('-2 years', 'now');
            $pegi_rating = $faker->randomElement([3, 7, 12, 16, 18]);
            
            // Image and Gallery
            $image = '/images/product-' . $faker->numberBetween(1, 16) . '.jpg'; // Random image from product-1.jpg to product-16.jpg
            $gallery = json_encode([
                "/images/product-1.jpg",
                "/images/product-2.jpg",
                "/images/product-3.jpg",
                "/images/product-4.jpg",
                "/images/product-5.jpg",
                "/images/product-6.jpg",
                "/images/product-7.jpg",
                "/images/product-8.jpg",
                "/images/product-9.jpg"
            ]); // Fixed gallery as per request
            $installer = ''; // Installer is empty as requested
            $is_active = 1; // Set to 1 as requested
            $meta_title = $title . ' - Meta Title';
            $meta_description = $faker->sentence;
            $meta_keywords = $faker->words(5, true);

            // Insert the product data into the database
            $productId = DB::table('products_uk')->insertGetId([
                'title' => $title,
                'slug' => $slug,
                'price' => $price,
                'old_price' => $old_price,
                'sku' => $sku,
                'excerpt' => $excerpt,
                'release_date' => $release_date,
                'pegi_rating' => $pegi_rating,
                'image' => $image,
                'gallery' => $gallery,
                'installer' => $installer,
                'is_active' => $is_active,
                'meta_title' => $meta_title,
                'meta_description' => $meta_description,
                'meta_keywords' => $meta_keywords,
            ]);

            DB::table('products_en')->insertGetId([
                'title' => $title,
                'slug' => $slug,
                'price' => $price,
                'old_price' => $old_price,
                'sku' => $sku,
                'excerpt' => $excerpt,
                'release_date' => $release_date,
                'pegi_rating' => $pegi_rating,
                'image' => $image,
                'gallery' => $gallery,
                'installer' => $installer,
                'is_active' => $is_active,
                'meta_title' => $meta_title,
                'meta_description' => $meta_description,
                'meta_keywords' => $meta_keywords,
            ]);

            // Attach random genres, categories, tags, and platforms
            $genres = Genre::inRandomOrder()->take(rand(1, 3))->pluck('id')->toArray();
            $categories = ProductCategory::inRandomOrder()->take(rand(1, 3))->pluck('id')->toArray();
            $tags = ProductTag::inRandomOrder()->take(rand(1, 3))->pluck('id')->toArray();
            $platforms = Platform::inRandomOrder()->take(rand(1, 3))->pluck('id')->toArray();

            // Attach to the product
            DB::table('products_genres')->insert(
                collect($genres)->map(fn($genreId) => ['id_products' => $productId, 'id_genres' => $genreId])->toArray()
            );

            DB::table('products_product_categories')->insert(
                collect($categories)->map(fn($categoryId) => ['id_products' => $productId, 'id_product_categories' => $categoryId])->toArray()
            );

            DB::table('products_product_tags')->insert(
                collect($tags)->map(fn($tagId) => ['id_products' => $productId, 'id_product_tags' => $tagId])->toArray()
            );

            DB::table('products_platforms')->insert(
                collect($platforms)->map(fn($platformId) => ['id_products' => $productId, 'id_platforms' => $platformId])->toArray()
            );
        }
    }
}
