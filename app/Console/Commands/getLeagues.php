<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FootballApiService;
use App\Models\League;

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
        $this->info("Getting Leagues");
        $apiService = new FootballApiService();
        $results = $apiService->getAllLeagues();
        $leagues = $results->api->leagues;

       foreach ($leagues as $league) {

        $dbLeague = new League;
        $dbLeague->league_id = $league->league_id;
        $dbLeague->name = $league->name;
        $dbLeague->type = $league->type;
        $dbLeague->country = $league->country;

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

       }

    }
}
