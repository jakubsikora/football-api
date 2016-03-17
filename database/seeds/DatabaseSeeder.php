<?php

use Illuminate\Database\Seeder;
use App\User;
use App\League;
use App\Team;
use App\Result;

class DatabaseSeeder extends Seeder
{
    private $tables = [
        'users',
        'leagues',
        'teams',
        'results',
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
        factory(League::class, 5)->create();
        factory(Team::class, 20)->create();
        factory(Result::class, 60)->create();
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

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    }
}
