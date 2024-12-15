<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticleTagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Gaming-related tags with random colors
        $tags = [
            ['title' => 'PC Gaming', 'color' => $this->generateRandomColor()],
            ['title' => 'Console Gaming', 'color' => $this->generateRandomColor()],
            ['title' => 'Mobile Gaming', 'color' => $this->generateRandomColor()],
            ['title' => 'Esports', 'color' => $this->generateRandomColor()],
            ['title' => 'RPG', 'color' => $this->generateRandomColor()],
            ['title' => 'FPS', 'color' => $this->generateRandomColor()],
            ['title' => 'MMORPG', 'color' => $this->generateRandomColor()],
            ['title' => 'MOBA', 'color' => $this->generateRandomColor()],
            ['title' => 'Battle Royale', 'color' => $this->generateRandomColor()],
            ['title' => 'Indie Games', 'color' => $this->generateRandomColor()],
            ['title' => 'Action-Adventure', 'color' => $this->generateRandomColor()],
            ['title' => 'Simulation Games', 'color' => $this->generateRandomColor()],
            ['title' => 'Strategy Games', 'color' => $this->generateRandomColor()],
            ['title' => 'Horror Games', 'color' => $this->generateRandomColor()],
            ['title' => 'Survival Games', 'color' => $this->generateRandomColor()],
            ['title' => 'Sandbox Games', 'color' => $this->generateRandomColor()],
            ['title' => 'VR Gaming', 'color' => $this->generateRandomColor()],
            ['title' => 'Retro Gaming', 'color' => $this->generateRandomColor()],
            ['title' => 'Game Reviews', 'color' => $this->generateRandomColor()],
            ['title' => 'Gaming News', 'color' => $this->generateRandomColor()],
        ];

        // Insert into article_tags_uk table
        foreach ($tags as $tag) {
            DB::table('article_tags_uk')->insert($tag);
        }

        // Insert into article_tags_en table
        foreach ($tags as $tag) {
            DB::table('article_tags_en')->insert($tag);
        }
    }

    /**
     * Generate a random color in hex format.
     *
     * @return string
     */
    private function generateRandomColor()
    {
        return '#' . strtoupper(dechex(rand(0x000000, 0xFFFFFF)));
    }
}
