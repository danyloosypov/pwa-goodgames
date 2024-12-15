<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use App\Models\Team;

class TeammatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Loop through each team and create 5 teammates for each
        $teams = Team::all(); // Fetch all teams

        foreach ($teams as $team) {
            for ($i = 0; $i < 5; $i++) {
                // Generate random teammate data
                $nickname = $faker->userName;
                $slug = Str::slug($nickname);
                $realName = $faker->name;
                $photo = 'teammate-1.jpg'; // Random teammate photo (teammate-1.jpg to teammate-4.jpg)
                $kdaRatioNum = $faker->randomFloat(2, 0, 5); // KDA ratio number
                $kdaRatioText = $kdaRatioNum < 1 ? 'Low' : ($kdaRatioNum < 3 ? 'Average' : 'High');
                $csPerMinNum = $faker->randomFloat(2, 0, 10); // CS per minute
                $csPerMinText = $csPerMinNum < 3 ? 'Low' : ($csPerMinNum < 7 ? 'Average' : 'High');
                $killParticipationNum = $faker->randomFloat(2, 0, 1); // Kill participation ratio
                $killParticipationText = $killParticipationNum < 0.3 ? 'Low' : ($killParticipationNum < 0.7 ? 'Average' : 'High');
                $biography = $faker->paragraph(2);
                $metaTitle = $faker->sentence(6);
                $metaDescription = $faker->sentence(10);
                $metaKeywords = implode(',', $faker->words(5));

                // Insert data into teammates_uk table
                DB::table('teammates_uk')->insert([
                    'nickname' => $nickname,
                    'slug' => $slug,
                    'real_name' => $realName,
                    'photo' => $photo,
                    'kda_ration_num' => $kdaRatioNum,
                    'kda_ration_text' => $kdaRatioText,
                    'cs_per_min_num' => $csPerMinNum,
                    'cs_per_min_text' => $csPerMinText,
                    'kill_participation_num' => $killParticipationNum,
                    'kill_participation_text' => $killParticipationText,
                    'biography' => $biography,
                    'id_teams' => $team->id, // Associate teammate with the current team
                    'meta_title' => $metaTitle,
                    'meta_description' => $metaDescription,
                    'meta_keywords' => $metaKeywords,
                ]);

                // Insert data into teammates_en table
                DB::table('teammates_en')->insert([
                    'nickname' => $nickname,
                    'slug' => $slug,
                    'real_name' => $realName,
                    'photo' => $photo,
                    'kda_ration_num' => $kdaRatioNum,
                    'kda_ration_text' => $kdaRatioText,
                    'cs_per_min_num' => $csPerMinNum,
                    'cs_per_min_text' => $csPerMinText,
                    'kill_participation_num' => $killParticipationNum,
                    'kill_participation_text' => $killParticipationText,
                    'biography' => $biography,
                    'id_teams' => $team->id, // Associate teammate with the current team
                    'meta_title' => $metaTitle,
                    'meta_description' => $metaDescription,
                    'meta_keywords' => $metaKeywords,
                ]);
            }
        }
    }
}
