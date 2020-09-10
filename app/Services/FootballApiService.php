<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;


/**
 * Rentals United XML service API
 * https://developer.rentalsunited.com/?xml#introduction
 *
 * @package App\Services
 */
class FootballApiService
{
  protected $apiKey;
  protected $endpoint;
  protected $demoURL;

  /**
   * Instantiate a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->apiKey = env('FOOTBALL_API_KEY');
    $this->endpoint = env('FOOTBALL_API_URL');
    $this->demoURL = env('FOOTBALL_API_DEMO_URL');
}

  public function getAllLeagues()
  {
    $response =Http::withHeaders([
        'X-RapidAPI-Key' => $this->apiKey,
    ])->get($this->endpoint . 'leagues');

    //$response =Http::get($this->demoURL . 'leagues');

    $results = json_decode($response->body());
    return $results;
  }

  public function getTeamsByLeague($league_id)
  {
    $response =Http::withHeaders([
        'X-RapidAPI-Key' => $this->apiKey,
    ])->get($this->endpoint . 'teams/league/' . $league_id);


    $results = json_decode($response->body());
    return $results;
  }

  public function getCurrentRoundOfLeague($league_id)
  {
    $response =Http::withHeaders([
        'X-RapidAPI-Key' => $this->apiKey,
    ])->get($this->endpoint . 'fixtures/rounds/' .$league_id . '/current');


    $results = json_decode($response->body());
    return $results;
  }

  public function getAllRoundsOfLeague($league_id)
  {
    $response =Http::withHeaders([
        'X-RapidAPI-Key' => $this->apiKey,
    ])->get($this->endpoint . 'fixtures/rounds/' . $league_id);


    $results = json_decode($response->body());
    return $results;
  }

  public function getFixturesByCurrentRound($league_id, $currentRound)
  {
    $response =Http::withHeaders([
        'X-RapidAPI-Key' => $this->apiKey,
    ])->get($this->endpoint . 'fixtures/league/'. $league_id . '/' . $currentRound);


    $results = json_decode($response->body());
    return $results;
  }

  public function getAllFixturesByLeagueId($league_id)
  {
    $response =Http::withHeaders([
        'X-RapidAPI-Key' => $this->apiKey,
    ])->get($this->endpoint . 'fixtures/league/'. $league_id);


    $results = json_decode($response->body());
    return $results;
  }



}
