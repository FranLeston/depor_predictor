<?php

namespace App\Console\Commands;

use App\Models\Fixture;
use App\Models\League;
use App\Services\FootballApiService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateLiveFixtures extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:updateLiveFixtures';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates fixtures in play';

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
        $this->updateLiveFixtures();
    }

    public function updateLiveFixtures()
    {

        //Find all fixtures in play
        $liveFixtures = Fixture::where('is_current', true)->where('league_id', 2847)->get();
        foreach ($liveFixtures as $key => $liveFixture) {
            $matchStart = Carbon::parse($liveFixture->event_timestamp);
            var_dump($matchStart);
            if ($matchStart->isPast()) {
                //$this->getAllFirstDivFixtures();
                //$this->getAllSecondDivFixtures();
                $this->getAllSecondDivBFixtures();
                break;
            }

        }
    }
    public function getAllSecondDivBFixtures()
    {
        $secondDivBLeague = League::where("is_current", 1)->where('country', "Spain")->where('name', "Segunda B - Group 1")->first();
        $apiService = new FootballApiService();

        $fixtureResults = $apiService->getAllFixturesByLeagueId($secondDivBLeague->league_id);
        $fixtures = $fixtureResults->api->fixtures;

        $results = $apiService->getCurrentRoundOfLeague($secondDivBLeague->league_id);
        $currentRound = str_replace('_', ' ', $results->api->fixtures[0]);

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
