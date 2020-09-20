<?php

namespace App\Console\Commands;

use App\Models\League;
use App\Models\Team;
use App\Services\FootballApiService;
use Illuminate\Console\Command;

class getTeams extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:getTeams';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'gets the teams and then stores them in DB';

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
        $this->getSpainFirstDivTeams();
        $this->getSpainSecondDivTeams();
        $this->getSpainSecondBDivTeams();

    }

    public function getSpainFirstDivTeams()
    {
        $firstDivLeague = League::where("is_current", 1)->where('country', "Spain")->where('name', "Primera Division")->first();
        $apiService = new FootballApiService();
        $results = $apiService->getTeamsByLeague($firstDivLeague->league_id);

        $teams = $results->api->teams;
        $this->info("Getting Spain First Div Teams...  Total:" . count($teams));

        foreach ($teams as $team) {

            $theTeam = Team::where('team_id', $team->team_id)->first();

            if (isset($theTeam)) {
                $this->updateDatabase($theTeam, $team);
            } else {
                $this->saveToDatabase($team);

            }

        }
        $this->info("Cool Beans! " . count($teams) . " Teams were updated!");

    }

    public function getSpainSecondDivTeams()
    {
        $secondDivLeague = League::where("is_current", 1)->where('country', "Spain")->where('name', "Segunda Division")->first();
        $apiService = new FootballApiService();
        $results = $apiService->getTeamsByLeague($secondDivLeague->league_id);

        $teams = $results->api->teams;
        $this->info("Getting Spain Second Div Teams...  Total:" . count($teams));

        foreach ($teams as $team) {

            $theTeam = Team::where('team_id', $team->team_id)->first();

            if (isset($theTeam)) {
                $this->updateDatabase($theTeam, $team);
            } else {
                $this->saveToDatabase($team);

            }

        }
        $this->info("Cool Beans! " . count($teams) . " Teams were updated!");

    }

    public function getSpainSecondBDivTeams()
    {
        $secondDivBLeague = League::where("is_current", 1)->where('country', "Spain")->where('name', "Segunda B - Group 1")->first();
        $apiService = new FootballApiService();
        $results = $apiService->getTeamsByLeague($secondDivBLeague->league_id);

        $teams = $results->api->teams;
        $this->info("Getting Spain Second Div Teams GROUP 1...  Total:" . count($teams));

        foreach ($teams as $team) {

            $theTeam = Team::where('team_id', $team->team_id)->first();

            if (isset($theTeam)) {
                $this->updateDatabase($theTeam, $team);
            } else {
                $this->saveToDatabase($team);

            }

        }
        $this->info("Cool Beans! " . count($teams) . " Teams were updated!");

    }

    public function saveToDatabase($team)
    {
        $dbTeam = new Team;

        $dbTeam->team_id = $team->team_id;
        $dbTeam->name = $team->name;
        $dbTeam->logo = $team->logo;
        $dbTeam->country = $team->country;
        $dbTeam->is_national = $team->is_national;
        $dbTeam->venue_name = $team->venue_name;
        $dbTeam->venue_city = $team->venue_city;

        $dbTeam->save();
        $this->info("Saved to DB: " . $team->team_id);
    }

    public function updateDatabase($theTeam, $team)
    {

        $theTeam->team_id = $team->team_id;
        $theTeam->name = $team->name;
        $theTeam->logo = $team->logo;
        $theTeam->country = $team->country;
        $theTeam->is_national = $team->is_national;
        $theTeam->venue_name = $team->venue_name;
        $theTeam->venue_city = $team->venue_city;

        $theTeam->save();
        $this->info("Updated DB Team: " . $team->team_id);
    }
}
