<?php

namespace App\Console\Commands;

use App\Models\Fixture;
use App\Models\League;
use App\Models\Round;
use App\Services\FootballApiService;
use Carbon\Carbon;
use Illuminate\Console\Command;

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

        $this->getAllFirstDivFixtures();
        $this->getAllSecondDivFixtures();
        $this->getAllSecondDivBFixtures();

    }
    public function getAllSecondDivBFixtures()
    {
        $secondDivBLeague = League::where("is_current", 1)->where('country', "Spain")->where('name', "Segunda B - Group 1")->first();
        $apiService = new FootballApiService();

        $fixtureResults = $apiService->getAllFixturesByLeagueId($secondDivBLeague->league_id);
        $fixtures = $fixtureResults->api->fixtures;

        $results = $apiService->getCurrentRoundOfLeague($secondDivBLeague->league_id);
        $currentRound = str_replace('_', ' ', $results->api->fixtures[0]);

        $this->updateRoundsByLeague($secondDivBLeague);
        $this->info("Getting Segunda B - Group 1 Fixtures...  Total:" . count($fixtures));

        foreach ($fixtures as $fixture) {
            if ($currentRound == $fixture->round) {
                $is_current = true;
            } else {
                $is_current = false;
            }

            Fixture::updateOrCreate([

                'fixture_id' => $fixture->fixture_id,
            ], [
                'league_id' => $fixture->league_id,
                'event_date' => Carbon::parse($fixture->event_date)->format('Y-m-d'),
                'event_timestamp' => date('Y-m-d H:i:s', $fixture->event_timestamp),
                'round' => $fixture->round,
                'is_current' => $is_current,
                'status' => $fixture->status,
                'home_team_id' => $fixture->homeTeam->team_id,
                'away_team_id' => $fixture->awayTeam->team_id,
                'goals_home_team' => $fixture->goalsHomeTeam,
                'goals_away_team' => $fixture->goalsAwayTeam,
            ]);

            $this->info("Saved to DB: " . $fixture->fixture_id);
        }

        $this->info("Cool Beans! " . count($fixtures) . " fixtures were updated!");

    }

    public function getAllFirstDivFixtures()
    {
        $firstDivLeague = League::where("is_current", 1)->where('country', "Spain")->where('name', "Primera Division")->first();
        $apiService = new FootballApiService();

        $fixtureResults = $apiService->getAllFixturesByLeagueId($firstDivLeague->league_id);
        $fixtures = $fixtureResults->api->fixtures;

        $results = $apiService->getCurrentRoundOfLeague($firstDivLeague->league_id);
        $currentRound = str_replace('_', ' ', $results->api->fixtures[0]);

        $this->updateRoundsByLeague($firstDivLeague);

        $this->info("Getting Primera Division Fixtures...  Total:" . count($fixtures));

        foreach ($fixtures as $fixture) {
            if ($currentRound == $fixture->round) {
                $is_current = true;
            } else {
                $is_current = false;
            }

            Fixture::updateOrCreate([

                'fixture_id' => $fixture->fixture_id,
            ], [
                'league_id' => $fixture->league_id,
                'event_date' => Carbon::parse($fixture->event_date)->format('Y-m-d'),
                'event_timestamp' => date('Y-m-d H:i:s', $fixture->event_timestamp),
                'round' => $fixture->round,
                'is_current' => $is_current,
                'status' => $fixture->status,
                'home_team_id' => $fixture->homeTeam->team_id,
                'away_team_id' => $fixture->awayTeam->team_id,
                'goals_home_team' => $fixture->goalsHomeTeam,
                'goals_away_team' => $fixture->goalsAwayTeam,
            ]);

            $this->info("Saved to DB: " . $fixture->fixture_id);
        }

        $this->info("Cool Beans! " . count($fixtures) . " fixtures were updated!");

    }

    public function getAllSecondDivFixtures()
    {
        $secondDivLeague = League::where("is_current", 1)->where('country', "Spain")->where('name', "Segunda Division")->first();
        $apiService = new FootballApiService();

        $fixtureResults = $apiService->getAllFixturesByLeagueId($secondDivLeague->league_id);
        $fixtures = $fixtureResults->api->fixtures;

        $results = $apiService->getCurrentRoundOfLeague($secondDivLeague->league_id);
        $currentRound = str_replace('_', ' ', $results->api->fixtures[0]);

        $this->updateRoundsByLeague($secondDivLeague);
        $this->info("Getting Segunda Division Teams...  Total:" . count($fixtures));

        foreach ($fixtures as $fixture) {
            if ($currentRound == $fixture->round) {
                $is_current = true;
            } else {
                $is_current = false;
            }

            Fixture::updateOrCreate([

                'fixture_id' => $fixture->fixture_id,
            ], [
                'league_id' => $fixture->league_id,
                'event_date' => Carbon::parse($fixture->event_date)->format('Y-m-d'),
                'event_timestamp' => date('Y-m-d H:i:s', $fixture->event_timestamp),
                'round' => $fixture->round,
                'is_current' => $is_current,
                'status' => $fixture->status,
                'home_team_id' => $fixture->homeTeam->team_id,
                'away_team_id' => $fixture->awayTeam->team_id,
                'goals_home_team' => $fixture->goalsHomeTeam,
                'goals_away_team' => $fixture->goalsAwayTeam,
            ]);

            $this->info("Saved to DB: " . $fixture->fixture_id);
        }

        $this->info("Cool Beans! " . count($fixtures) . " fixtures were updated!");

    }

    public function updateRoundsByLeague($league)
    {
        $apiService = new FootballApiService();

        $roundsResults = $apiService->getAllRoundsOfLeague($league->league_id);
        $rounds = $roundsResults->api->fixtures;

        $results = $apiService->getCurrentRoundOfLeague($league->league_id);
        $currentRound = str_replace('_', ' ', $results->api->fixtures[0]);

        $this->info("Getting Rounds...  Total:" . count($rounds));

        foreach ($rounds as $round => $value) {
            $formatRound = str_replace('_', ' ', $value);

            if ($currentRound == $formatRound) {
                $is_current = true;
            } else {
                $is_current = false;
            }

            Round::updateOrCreate([

                'round' => $league->league_id . "_" . $formatRound,
            ], [
                'league_id' => $league->league_id,
                'league_name' => $league->name,
                'season_start' => $league->season_start,
                'season_end' => $league->season_end,
                'type' => $league->type,
                'is_current' => $is_current,

            ]);

            $this->info("Saved to DB: ");
        }

        $this->info("Cool Beans! " . count($rounds) . " rounds were updated!");

    }

    // public function updateRounds()
    // {

    //     $spanish1Div = League::where(country)

    //     $leagues = League::all();

    //     if (isset($leagues)) {
    //         foreach ($leagues as $key => $league) {
    //             $this->updateRoundsByLeague($league->league_id, $league->name);
    //         }
    //     }
    // }

}
