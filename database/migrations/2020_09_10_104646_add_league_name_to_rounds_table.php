<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLeagueNameToRoundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rounds', function (Blueprint $table) {
            $table->string('league_name')->after('league_id')->nullable();
            $table->dateTime('season_start')->after('league_name')->nullable();
            $table->dateTime('season_end')->after('season_start')->nullable();
            $table->string('type')->after('season_end')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rounds', function (Blueprint $table) {
            $table->dropColumn('league_name');
            $table->dropColumn('season_start');
            $table->dropColumn('season_end');
            $table->dropColumn('type');

        });
    }
}
