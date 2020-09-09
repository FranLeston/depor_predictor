<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Fixture;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class FixtureController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request  $request

     */
    public function index(Request $request)
    {
        if ($request->has('status') && $request->input('status') == "NotStarted") {
            $activeFixtures = Fixture::with('homeTeam', 'awayTeam')
                ->where('status', 'Not Started')
                ->where('is_current', true)
                ->where(function ($query) {
                    $query->where('home_team_id', 538)
                        ->orWhere('home_team_id', 529)
                        ->orWhere('home_team_id', 541)
                        ->orWhere('away_team_id', 538)
                        ->orWhere('away_team_id', 529)
                        ->orWhere('away_team_id', 541)
                        ->orWhere('home_team_id', 716)
                        ->orWhere('away_team_id', 716);
                })
                ->orderBy('event_timestamp', 'ASC')->get();

            return response()->json(['fixtures' => $activeFixtures], 200);
        } else {
            $allFixtures = Fixture::all();
            return response()->json(['fixtures' => $allFixtures], 200);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function activeFixtures()
    {
        $activeFixtures = Fixture::with('homeTeam', 'awayTeam')->where('status', 'Not Started')->where('is_current', true)->get();

        return response()->json(['fixtures' => $activeFixtures], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        try {
            $fixture = Fixture::findorfail($id);
            return response()->json(['fixture' => $fixture], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['Error' => $e->getMessage()], 404);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
