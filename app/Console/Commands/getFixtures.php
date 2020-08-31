<?php

namespace App\Console\Commands;

use App\Models\Fixture;
use Illuminate\Console\Command;
use App\Models\League;
use App\Services\FootballApiService;
use Carbon\Carbon;


class getFixtures extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:getFixtures';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets Fixtures';

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
        $this->getAllFixtures();
    }

    public function getAllFixtures() {
        $secondDivLeague = League::where("is_current", 1)->where('country', "Spain")->where('name', "Segunda Division")->first();
        $apiService = new FootballApiService();

        $fixtureResults = $apiService->getAllFixturesByLeagueId($secondDivLeague->league_id);
        $fixtures = $fixtureResults->api->fixtures;

        $results = $apiService->getCurrentRoundOfLeague($secondDivLeague->league_id);
        $currentRound = str_replace('_', ' ', $results->api->fixtures[0]);

        $this->info("Getting Teams...  Total:" . count($fixtures));

        foreach ($fixtures as $fixture) {
        if ($currentRound == $fixture->round) {
            $is_current = true;
        } else {
            $is_current = false;
        }

         Fixture::updateOrCreate([

                'fixture_id'   => $fixture->fixture_id,
            ],[
                'league_id'     => $fixture->league_id,
                'event_date' => Carbon::parse($fixture->event_date)->format('Y-m-d'),
                'event_timestamp'    =>date('Y-m-d H:i:s', $fixture->event_timestamp),
                'round'   => $fixture->round,
                'is_current' => $is_current,
                'status'       => $fixture->status,
                'home_team_id'       => $fixture->homeTeam->team_id,
                'away_team_id'       => $fixture->awayTeam->team_id,
                'goals_home_team'   => $fixture->goalsHomeTeam,
                'goals_away_team'    => $fixture->goalsAwayTeam
            ]);



            $this->info("Saved to DB: " . $fixture->fixture_id);
           }

           $this->info("Cool Beans! " .count($fixtures) ." fixtures were updated!");

    }

}
