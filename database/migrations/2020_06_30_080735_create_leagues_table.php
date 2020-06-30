<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaguesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leagues', function (Blueprint $table) {
            $table->id();
            $table->integer('league_id')->unique();
            $table->string('name');
            $table->string('type');
            $table->string('country');
            $table->dateTime('season_start')->nullable();
            $table->dateTime('season_end')->nullable();
            $table->string('logo')->nullable();
            $table->string('flag')->nullable();
            $table->integer('is_current');

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
        Schema::dropIfExists('leagues');
    }
}
