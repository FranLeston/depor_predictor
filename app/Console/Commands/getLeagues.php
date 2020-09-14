<?php

namespace App\Console\Commands;

use App\Models\League;
use App\Services\FootballApiService;
use Illuminate\Console\Command;

class getLeagues extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:getLeagues';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'stores leagues in db';

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

        $apiService = new FootballApiService();
        $results = $apiService->getAllLeagues();
        $leagues = $results->api->leagues;
        $this->info("Getting Leagues.  Total:" . count($leagues));

        foreach ($leagues as $league) {

            $theLeague = League::where('league_id', $league->league_id)->first();

            if (isset($theLeague)) {
                $this->updateDatabase($theLeague, $league);
            } else {
                $this->saveToDatabase($league);

            }

        }
        $this->info("Cool Beans! " . count($leagues) . " Leagues were updated!");

    }

    public function saveToDatabase($league)
    {
        $dbLeague = new League;
        $dbLeague->league_id = $league->league_id;
        $dbLeague->name = $league->name;
        $dbLeague->type = $league->type;
        $dbLeague->country = $league->country;
        $dbLeague->season = $league->season;

        if ($league->season_start != "" || $league->season_start != null) {
            $dbLeague->season_start = $league->season_start;
        } else {
            $dbLeague->season_start = null;
        }

        if ($league->season_end != "" || $league->season_end != null) {
            $dbLeague->season_end = $league->season_end;
        } else {
            $dbLeague->season_end = null;
        }

        $dbLeague->logo = $league->logo;
        $dbLeague->flag = $league->flag;
        $dbLeague->is_current = $league->is_current;

        $dbLeague->save();
        $this->info("Saved to DB: " . $league->league_id);
    }

    public function updateDatabase($theLeague, $league)
    {
        $theLeague->league_id = $league->league_id;
        $theLeague->name = $league->name;
        $theLeague->type = $league->type;
        $theLeague->country = $league->country;
        $theLeague->season = $league->season;

        if ($league->season_start != "" || $league->season_start != null) {
            $theLeague->season_start = $league->season_start;
        } else {
            $theLeague->season_start = null;
        }

        if ($league->season_end != "" || $league->season_end != null) {
            $theLeague->season_end = $league->season_end;
        } else {
            $theLeague->season_end = null;
        }

        $theLeague->logo = $league->logo;
        $theLeague->flag = $league->flag;
        $theLeague->is_current = $league->is_current;

        $theLeague->save();
        $this->info("Update League in DB: " . $league->league_id);
    }

}
