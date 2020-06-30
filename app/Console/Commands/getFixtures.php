<?php

namespace App\Console\Commands;

use App\Models\Fixture;
use Illuminate\Console\Command;
use App\Models\League;
use App\Services\FootballApiService;

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
        $this->getCurrentRoundFixtures();
    }

    public function getCurrentRoundFixtures() {
        $secondDivLeague = League::where("is_current", 1)->where('country', "Spain")->where('name', "Segunda Division")->first();
        $apiService = new FootballApiService();
        $results = $apiService->getCurrentRoundOfLeague($secondDivLeague->league_id);
        $currentRound = $results->api->fixtures;

        $fixtureResults = $apiService->getFixturesByCurrentRound($secondDivLeague->league_id, $currentRound[0]);
        $fixtures = $fixtureResults->api->fixtures;

        $this->info("Getting Teams...  Total:" . count($fixtures));

        foreach ($fixtures as $fixture) {

            $theFixture = Fixture::where('fixture_id', $fixture->fixture_id)->first();

            if (isset($theFixture)){
                $this->updateDatabase($theFixture, $fixture);
            } else {
                $this->saveToDatabase($fixture);

            }

           }
           $this->info("Cool Beans! " .count($fixtures) ." fixtures were updated!");

    }

    public function saveToDatabase($fixture) {
        $dbFixture = new Fixture;

        $dbFixture->fixture_id = $fixture->fixture_id;
        $dbFixture->league_id = $fixture->league_id;
        $dbFixture->event_date = $fixture->event_date;
        $dbFixture->event_timestamp = date('Y-m-d H:i:s', $fixture->event_timestamp);

        $dbFixture->round= $fixture->round;
        $dbFixture->status= $fixture->status;
        $dbFixture->home_team_id = $fixture->homeTeam->team_id;
        $dbFixture->away_team_id = $fixture->awayTeam->team_id;
        $dbFixture->goals_home_team = $fixture->goalsHomeTeam;
        $dbFixture->goals_away_team = $fixture->goalsAwayTeam;

        $dbFixture->save();
        $this->info("Saved to DB: " . $fixture->fixture_id);

    }

    public function updateDatabase($theFixture, $fixture) {


        $theFixture->fixture_id = $fixture->fixture_id;
        $theFixture->league_id = $fixture->league_id;
        $theFixture->event_date = $fixture->event_date;
        $theFixture->event_timestamp = date('Y-m-d H:i:s', $fixture->event_timestamp);
        $theFixture->round= $fixture->round;
        $theFixture->status= $fixture->status;
        $theFixture->home_team_id = $fixture->homeTeam->team_id;
        $theFixture->away_team_id = $fixture->awayTeam->team_id;
        $theFixture->goals_home_team = $fixture->goalsHomeTeam;
        $theFixture->goals_away_team = $fixture->goalsAwayTeam;

        $theFixture->save();
        $this->info("Updated DB: " . $fixture->fixture_id);

    }
}
