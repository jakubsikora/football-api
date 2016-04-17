<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertLeagues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $leagues = array(
            array('name' => 'Premier League', 'code' => 'E0', 'country' => 'England'),
            array('name' => 'Championship', 'code' => 'E1', 'country' => 'England'),
            array('name' => 'League 1', 'code' => 'E2', 'country' => 'England'),
            array('name' => 'League 2', 'code' => 'E3', 'country' => 'England'),
            array('name' => 'Conference', 'code' => 'EC', 'country' => 'England'),
        );

        DB::table('leagues')->insert($leagues);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('leagues')->truncate();
    }
}
