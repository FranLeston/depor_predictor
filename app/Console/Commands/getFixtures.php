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
                'event_date' => Carbon::parse($fixture->event_date)->format('Y-m-d H:i:s'),
                'event_timestamp' => Carbon::createFromTimestamp($fixture->event_timestamp)->format('Y-m-d H:i:s'),
                'round' => $fixture->round,
                'is_current' => $is_current,
                'status' => $fixture->status,
                'status_esp' => $this->getStatusEsp($fixture->statusShort),
                'short_status' => $fixture->statusShort,
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
                'event_date' => Carbon::parse($fixture->event_date)->format('Y-m-d H:i:s'),
                'event_timestamp' => Carbon::createFromTimestamp($fixture->event_timestamp)->format('Y-m-d H:i:s'),
                'round' => $fixture->round,
                'is_current' => $is_current,
                'short_status' => $fixture->statusShort,
                'status_esp' => $this->getStatusEsp($fixture->statusShort),
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
                'event_date' => Carbon::parse($fixture->event_date)->format('Y-m-d H:i:s'),
                'event_timestamp' => Carbon::createFromTimestamp($fixture->event_timestamp)->format('Y-m-d H:i:s'),
                'round' => $fixture->round,
                'is_current' => $is_current,
                'status' => $fixture->status,
                'status_esp' => $this->getStatusEsp($fixture->statusShort),
                'short_status' => $fixture->statusShort,
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

            $this->info("Saved Round to DB");
        }

        $this->info("Cool Beans! " . count($rounds) . " rounds were updated!");

    }

    public function getStatusEsp($status)
    {

        switch ($status) {
            case 'TBD':
                return "Sin Hora";
                break;
            case 'NS':
                return "Sin Empezar";
                break;
            case '1H':
                return "Primera Parte";
                break;
            case 'HT':
                return "Medio Tiempo";
                break;
            case '2H':
                return "Segunda Parte";
                break;
            case 'ET':
                return "Prorroga";
                break;
            case 'P':
                return "Penalti Señalado";
                break;
            case 'FT':
                return "Finalizado";
                break;
            case 'AET':
                return "Finalizado Con Prorroga";
                break;
            case 'PEN':
                return "Finalizado Con Penaltis";
                break;
            case 'BT':
                return "Tiempo Muerto";
                break;
            case 'SUSP':
                return "Partido Suspendido";
                break;
            case 'INT':
                return "Partido Interrumpido";
                break;
            case 'PST':
                return "Partido Aplazado";
                break;
            case 'CANC':
                return "Partido Cancelado";
                break;
            case 'ABD':
                return "Partido Abandonado";
                break;
            case 'AWD':
                return "Partido Perdido Tecnico";
                break;
            case 'WO':
                return "Partido Triunfo Tecnico";
                break;
            default:
                return "Sin Estado";
                break;
        }

    }

}
