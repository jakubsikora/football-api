<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Season;
use App\League;
use App\Team;

class DatabaseSeeder extends Seeder
{
    private $tables = [
        'users',
        'seasons',
        'leagues',
        'league_season',
        'teams',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->cleanDatabase();

        factory(User::class, 50)->create();
        factory(Season::class, 10)->create();
        factory(League::class, 2)->create();
        factory(Team::class, 20)->create();

        $seasons = App\Season::lists('id');

        for ($i = 1; $i <= 10; $i++) {
            DB::table('league_season')->insert([
                'league_id' => 1,
                'season_id' => $i
            ]);
        }

        for ($i = 1; $i <= 2; $i++) {
            DB::table('league_season')->insert([
                'league_id' => 2,
                'season_id' => $i
            ]);
        }
    }

    /**
     * [cleanDatabase description]
     * @return [type] [description]
     */
    private function cleanDatabase()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        foreach ($this->tables as $tableName) {
            DB::table($tableName)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
