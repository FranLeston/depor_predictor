<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Fixture;
use App\Models\Prediction;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PredictionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Display all Predictions for the current user

        $user_id = Auth::user()->id;

        $fixtures = Fixture::with('predictions')->with('homeTeam', 'awayTeam')
            ->with(['predictions' => function ($query) use ($user_id) {
                $query->where('user_id', '=', $user_id);
            }]);

        if ($request->has('status')) {
            $fixtures->where(function ($query) use ($request) {
                $query->where('status', $request->input('status'));
            });
        }

        if ($request->has('league_id')) {
            $fixtures->where(function ($query) use ($request) {
                $query->where('league_id', $request->input('league_id'));
            });
        }

        if ($request->has('is_current')) {
            $fixtures->where(function ($query) use ($request) {
                $query->where('is_current', $request->input('is_current'));
            });
        }

        $results = $fixtures->orderBy('event_timestamp', 'ASC')->get();

        return response()->json(['predictions' => $results], 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $request->validate([
            'fixture_id' => ['required', 'integer'],
            'home_team_prediction' => ['required', 'integer'],
            'away_team_prediction' => ['required', 'integer'],
        ]);

        $prediction = Prediction::updateOrCreate([

            'fixture_id' => $data['fixture_id'],
            'user_id' => Auth::user()->id,
        ],
            ['user_id' => Auth::user()->id,
                'fixture_id' => $data['fixture_id'],
                'home_team_prediction' => $data['home_team_prediction'],
                'away_team_prediction' => $data['away_team_prediction'],
            ]);

        return response()->json(['prediction' => $prediction], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
        $data = $request->all();
        $request->validate([
            'home_team_prediction' => ['required', 'integer'],
            'away_team_prediction' => ['required', 'integer'],
        ]);

        try {
            $prediction = Prediction::findorfail($id);
            $prediction->home_team_prediction = $data['home_team_prediction'];
            $prediction->away_team_prediction = $data['away_team_prediction'];
            $prediction->save();
            return response()->json(['prediction' => $prediction], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['Error' => $e->getMessage()], 404);
        }

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
