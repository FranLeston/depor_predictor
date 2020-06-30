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


}
