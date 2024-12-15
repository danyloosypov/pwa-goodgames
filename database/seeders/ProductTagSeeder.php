<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Tags data with random colors
        $tags = [
            ['title' => 'Multiplayer', 'color' => $this->generateRandomColor()],
            ['title' => 'Singleplayer', 'color' => $this->generateRandomColor()],
            ['title' => 'Co-op', 'color' => $this->generateRandomColor()],
            ['title' => 'Open World', 'color' => $this->generateRandomColor()],
            ['title' => 'Survival', 'color' => $this->generateRandomColor()],
            ['title' => 'Fantasy', 'color' => $this->generateRandomColor()],
            ['title' => 'Sci-Fi', 'color' => $this->generateRandomColor()],
            ['title' => 'First-person', 'color' => $this->generateRandomColor()],
            ['title' => 'Third-person', 'color' => $this->generateRandomColor()],
            ['title' => 'Indie', 'color' => $this->generateRandomColor()],
            ['title' => 'Casual', 'color' => $this->generateRandomColor()],
            ['title' => 'Horror', 'color' => $this->generateRandomColor()],
            ['title' => 'PvP', 'color' => $this->generateRandomColor()],
            ['title' => 'PvE', 'color' => $this->generateRandomColor()],
            ['title' => 'Story-rich', 'color' => $this->generateRandomColor()],
            ['title' => 'Sandbox', 'color' => $this->generateRandomColor()],
            ['title' => 'Stealth', 'color' => $this->generateRandomColor()],
            ['title' => 'Roguelike', 'color' => $this->generateRandomColor()],
            ['title' => 'RTS', 'color' => $this->generateRandomColor()],
            ['title' => 'MOBA', 'color' => $this->generateRandomColor()],
        ];

        // Insert into product_tags_uk table
        foreach ($tags as $tag) {
            DB::table('product_tags_uk')->insert($tag);
        }

        // Insert into product_tags_en table
        foreach ($tags as $tag) {
            DB::table('product_tags_en')->insert($tag);
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
