<?php

namespace App\Console\Commands;

use App\Models\Prediction;
use Illuminate\Console\Command;

class calculatePoints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:calculatePoints';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
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

                    if ($home_final - $away_final === $homePredict - $awayPredict || $away_final - $home_final === $awayPredict - $homePredict) {

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
