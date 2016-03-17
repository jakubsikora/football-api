<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('league_id')->unsigned();
            $table->date('date');
            $table->integer('home_team_id')->unsigned();
            $table->integer('away_team_id')->unsigned();
            $table->integer('ft_home_goals');
            $table->integer('ft_away_goals');
            $table->enum('ft_result', ['h', 'd', 'a']);
            $table->integer('ht_home_goals')->nullable();
            $table->integer('ht_away_goals')->nullable();
            $table->enum('ht_result', ['h', 'd', 'a'])->nullable();
            $table->string('referee')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('league_id')
                  ->references('id')
                  ->on('leagues')
                  ->onDelete('cascade');

            $table->foreign('home_team_id')
                  ->references('id')
                  ->on('teams')
                  ->onDelete('cascade');

            $table->foreign('away_team_id')
                  ->references('id')
                  ->on('teams')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('results');
    }
}
