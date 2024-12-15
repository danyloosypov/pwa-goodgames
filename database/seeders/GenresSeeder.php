<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Genres data
        $genres = [
            ['title' => 'Action'],
            ['title' => 'Adventure'],
            ['title' => 'Comedy'],
            ['title' => 'Drama'],
            ['title' => 'Fantasy'],
            ['title' => 'Horror'],
            ['title' => 'Mystery'],
            ['title' => 'Romance'],
            ['title' => 'Sci-Fi'],
            ['title' => 'Thriller'],
            ['title' => 'Western'],
            ['title' => 'Crime'],
            ['title' => 'Historical'],
            ['title' => 'Musical'],
            ['title' => 'War'],
            ['title' => 'Animation'],
            ['title' => 'Biography'],
            ['title' => 'Documentary'],
            ['title' => 'Family'],
            ['title' => 'Sport'],
        ];

        // Insert into genres_uk table
        foreach ($genres as $genre) {
            DB::table('genres_uk')->insert($genre);
        }

        // Insert into genres_en table
        foreach ($genres as $genre) {
            DB::table('genres_en')->insert($genre);
        }
    }
}
