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

        $query = Fixture::with('homeTeam', 'awayTeam')->with('league');

        if ($request->has('status')) {
            $query->where(function ($query) use ($request) {
                $query->where('status', $request->input('status'));
            });
        }

        if ($request->has('league_id')) {
            $query->where(function ($query) use ($request) {
                $query->where('league_id', $request->input('league_id'));
            });
        }

        if ($request->has('is_current')) {
            $query->where(function ($query) use ($request) {
                $query->where('is_current', $request->input('is_current'));
            });
        }

        $fixtures = $query->orderBy('event_timestamp', 'ASC')->get();

        return response()->json(['fixtures' => $fixtures], 200);

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
