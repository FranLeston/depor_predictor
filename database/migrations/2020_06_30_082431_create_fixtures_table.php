<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFixturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixtures', function (Blueprint $table) {
            $table->id();
            $table->integer('fixture_id');
            $table->foreignId('league_id')->constrained();
            $table->date('event_date');
            $table->timestamp('event_timestamp');
            $table->string('round');
            $table->string('status');
            $table->integer('home_team_id');
            $table->foreign('home_team_id')->references('team_id')->on('teams');
            $table->integer('away_team_id');
            $table->foreign('away_team_id')->references('team_id')->on('teams');
            $table->integer('goals_home_team');
            $table->integer('goals_away_team');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fixtures');
    }
}
