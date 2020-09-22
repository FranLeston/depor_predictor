<?php

namespace App\Observers;

use App\Console\Commands\calculatePoints;
use App\Models\Fixture;
use App\Models\Prediction;

class FixtureObserver
{
    /**
     * Handle the fixture "created" event.
     *
     * @param  \App\Models\Fixture  $fixture
     * @return void
     */
    public function created(Fixture $fixture)
    {
        //
    }

    /**
     * Handle the fixture "updated" event.
     *
     * @param  \App\Models\Fixture  $fixture
     * @return void
     */
    public function updated(Fixture $fixture)
    {

        if ($fixture->isDirty('short_status')) {
            // status has changed
            $new_status = $fixture->short_status;
            if ($this->isEnded($new_status)) {
                $this->calculatePoints();
            }

        }

    }

    /**
     * Handle the fixture "deleted" event.
     *
     * @param  \App\Models\Fixture  $fixture
     * @return void
     */
    public function deleted(Fixture $fixture)
    {
        //
    }

    /**
     * Handle the fixture "restored" event.
     *
     * @param  \App\Models\Fixture  $fixture
     * @return void
     */
    public function restored(Fixture $fixture)
    {
        //
    }

    /**
     * Handle the fixture "force deleted" event.
     *
     * @param  \App\Models\Fixture  $fixture
     * @return void
     */
    public function forceDeleted(Fixture $fixture)
    {
        //
    }

    public function isEnded($new_status)
    {

        if ($new_status === 'FT') {
            return true;
        } else if ($new_status === 'AET') {
            return true;
        } else if ($new_status === 'PEN') {
            return true;
        } else {
            return false;
        }

    }

    public function calculatePoints()
    {
        var_dump('Calculating Points');
        //get all users with points = null
        $predictions = Prediction::with('fixture')->whereNull('points', null)->get();

        foreach ($predictions as $key => $prediction) {

            $validMatches = array("FT", "PEN", "AET");
            $matchStatus = $prediction->fixture->short_status;
            if (in_array($matchStatus, $validMatches)) {
                $points = 0;
                $is_exact = false;
                $homePredict = $prediction->home_team_prediction;
                $awayPredict = $prediction->away_team_prediction;
                $home_final = $prediction->fixture->goals_home_team;
                $away_final = $prediction->fixture->goals_away_team;

                if ($home_final || $away_final) {

                    if ($home_final === $homePredict && $away_final === $awayPredict) {
                        $points = $points + 4;
                        $is_exact = true;
                    } else if ($home_final === $homePredict || $away_final === $awayPredict) {

                        $points = $points + 3;
                    }

                    if ($home_final - $away_final === $homePredict - $awayPredict) {

                        $points = $points + 1;
                    }

                    $newPrediction = Prediction::find($prediction->id);
                    $newPrediction->points = $points;
                    $newPrediction->is_exact = $is_exact;
                    $newPrediction->save();

                }

            }
        }

    }
}
