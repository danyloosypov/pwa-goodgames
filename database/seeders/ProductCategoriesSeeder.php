<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Categories data related to computer games
        $categories = [
            ['title' => 'Action'],
            ['title' => 'Adventure'],
            ['title' => 'RPG'],
            ['title' => 'Strategy'],
            ['title' => 'Shooter'],
            ['title' => 'Simulation'],
            ['title' => 'Puzzle'],
            ['title' => 'Racing'],
            ['title' => 'Sports'],
            ['title' => 'Fighting'],
            ['title' => 'Survival'],
            ['title' => 'Open World'],
            ['title' => 'MMORPG'],
            ['title' => 'Indie'],
            ['title' => 'Platformer'],
            ['title' => 'Horror'],
            ['title' => 'Sandbox'],
            ['title' => 'Multiplayer'],
            ['title' => 'Rhythm'],
            ['title' => 'Stealth'],
        ];

        // Insert into product_categories_uk table
        foreach ($categories as $category) {
            DB::table('product_categories_uk')->insert($category);
        }

        // Insert into product_categories_en table
        foreach ($categories as $category) {
            DB::table('product_categories_en')->insert($category);
        }
    }
}
