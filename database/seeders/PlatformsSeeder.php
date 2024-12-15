<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlatformsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Platform data
        $platforms = [
            ['title' => 'PC'],
            ['title' => 'Mobile'],
            ['title' => 'Console'],
        ];

        // Insert into platforms_uk table
        foreach ($platforms as $platform) {
            DB::table('platforms_uk')->insert($platform);
        }

        // Insert into platforms_en table
        foreach ($platforms as $platform) {
            DB::table('platforms_en')->insert($platform);
        }
    }
}
