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
            $points = 0;
            $homePredict = $prediction->home_team_prediction;
            $awayPredict = $prediction->away_team_prediction;
            $home_final = $prediction->fixture->goals_home_team;
            $away_final = $prediction->fixture->goals_away_team;

            if ($home_final === $homePredict && $away_final === $awayPredict) {
                var_dump("correct");
                $points = $points + 5;
            } else if ($home_final === $homePredict || $away_final === $awayPredict) {

                var_dump("only 1");

                $points = $points + 3;
            } else if ($home_final - $away_final === $homePredict - $awayPredict) {
                var_dump("diff");

                $points = $points + 1;
            }

            $newPrediction = Prediction::find($prediction->id);
            $newPrediction->points = $points;
            $newPrediction->save();

        }

    }
}
