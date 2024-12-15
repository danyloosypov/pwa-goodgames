<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticleCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Gaming-related categories
        $categories = [
            ['title' => 'PC Gaming'],
            ['title' => 'Console Gaming'],
            ['title' => 'Mobile Gaming'],
            ['title' => 'Esports'],
            ['title' => 'Game Reviews'],
            ['title' => 'Game Updates'],
            ['title' => 'Indie Games'],
            ['title' => 'Game Development'],
            ['title' => 'Retro Gaming'],
            ['title' => 'Gaming News'],
        ];

        // Insert into article_categories_uk table
        foreach ($categories as $category) {
            DB::table('article_categories_uk')->insert($category);
        }

        // Insert into article_categories_en table
        foreach ($categories as $category) {
            DB::table('article_categories_en')->insert($category);
        }
    }
}
