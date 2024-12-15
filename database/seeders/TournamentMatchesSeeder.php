<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Tournament;
use App\Models\Team;
use Faker\Factory as Faker;

class TournamentMatchesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Loop through each tournament and create 3 matches for each
        $tournaments = Tournament::all(); // Fetch all tournaments

        foreach ($tournaments as $tournament) {
            for ($i = 0; $i < 3; $i++) {
                // Randomly select two teams for the match
                $teams = Team::inRandomOrder()->take(2)->get(); // Select two random teams

                // Generate random match data
                $datetime = $faker->dateTimeBetween('+1 week', '+1 month');
                $result = rand(0, 1) == 0 ? 'Win' : 'Lose'; // Random result (Win or Lose)

                // Insert match data into 'tournament_matches_en' and 'tournament_matches_uk'
                $matchData = [
                    'datetime' => $datetime,
                    'result' => $result,
                    'id_tournaments' => $tournament->id,
                ];

                // Insert into 'tournament_matches_en'
                $matchEnId = DB::table('tournament_matches_en')->insertGetId($matchData);

                // Insert into 'tournament_matches_uk'
                $matchUkId = DB::table('tournament_matches_uk')->insertGetId($matchData);

                // Attach the selected teams to the match in the tournament_matches_teams pivot table for both languages
                foreach ($teams as $team) {
                    DB::table('tournament_matches_teams')->insert([
                        'id_tournament_matches' => $matchEnId,
                        'id_teams' => $team->id,
                    ]);

                    DB::table('tournament_matches_teams')->insert([
                        'id_tournament_matches' => $matchUkId,
                        'id_teams' => $team->id,
                    ]);
                }
            }
        }
    }
}
