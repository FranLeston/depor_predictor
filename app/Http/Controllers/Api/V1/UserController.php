<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->has('league_id')) {
            $league_id = $request->input('league_id');
        }

        $users = User::join('predictions', 'predictions.user_id', '=', 'users.id')
            ->join('fixtures', 'fixtures.fixture_id', '=', 'predictions.fixture_id')
            ->join('leagues', 'leagues.league_id', '=', 'fixtures.league_id')
            ->select(
                'users.name',
                'users.id',
                DB::raw('SUM(predictions.points) as total'),
                DB::raw('COUNT(predictions.points) as played'))
            ->where('leagues.league_id', '=', $league_id)
            ->orderBy('total', 'DESC')
            ->groupBy('users.name')->get();

        return response()->json(['users' => $users], 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if ($request->has('league_id')) {
            $league_id = $request->input('league_id');
        }
        $user = User::join('predictions', 'predictions.user_id', '=', 'users.id')
            ->join('fixtures', 'fixtures.fixture_id', '=', 'predictions.fixture_id')
            ->join('leagues', 'leagues.league_id', '=', 'fixtures.league_id')
            ->select(
                'users.name',
                'users.id',
                DB::raw('SUM(predictions.points) as total'),
                DB::raw('COUNT(predictions.points) as played'))
            ->where('leagues.league_id', '=', $league_id)
            ->where('users.id', '=', $id)
            ->orderBy('total', 'DESC')
            ->groupBy('users.name')->get();

        return response()->json(['user' => $user], 200);
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
        //updates User image and name
        $data = $request->all();
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($id)],
            'avatar' => ['file', 'size:3000'],
        ]);

        $imageName = time() . '.' . $request->avatar->getClientOriginalExtension();
        $request->avatar->move(public_path('images/profile'), $imageName);

        $user = User::find($id);

        $user->name = $data['name'];
        $user->avatr = $imageName;
        $user->save();

        return response()->json(['user' => $user], 200);
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
