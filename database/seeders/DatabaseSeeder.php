<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Database\Seeders\ArticleCategoriesSeeder;
use Database\Seeders\ArticlesSeeder;
use Database\Seeders\ArticleTagsSeeder;
use Database\Seeders\GenresSeeder;
use Database\Seeders\ProductCategoriesSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\ProductTagSeeder;
use Database\Seeders\PlatformsSeeder;
use Database\Seeders\TeammatesSeeder;
use Database\Seeders\TeamsSeeder;
use Database\Seeders\TournamentMatchesSeeder;
use Database\Seeders\TournamentsSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Articles and Article-related seeders
            ArticleCategoriesSeeder::class,  // Article Categories Seeder
            ArticleTagsSeeder::class,  // Article Tags Seeder
            ArticlesSeeder::class,  // Articles Seeder

            // Product and Product-related seeders
            GenresSeeder::class,  // Genres Seeder
            ProductCategoriesSeeder::class,  // Product Categories Seeder
            ProductTagSeeder::class,  // Product Tags Seeder
            PlatformsSeeder::class,  // Platforms Seeder
            ProductSeeder::class,  // Product Seeder

            // Teams and Tournament-related seeders
            TeamsSeeder::class,  // Teams Seeder
            TeammatesSeeder::class,  // Teammates Seeder
            TournamentsSeeder::class,  // Tournaments Seeder
            TournamentMatchesSeeder::class,  // Tournament Matches Seeder
        ]);
    }
}
