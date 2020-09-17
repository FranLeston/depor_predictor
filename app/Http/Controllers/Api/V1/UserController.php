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
                'users.avatar',
                'users.name',
                'users.id',
                DB::raw('SUM(predictions.points) as total'),
                DB::raw('SUM(predictions.is_exact) as exact'),
                DB::raw('COUNT(predictions.points) as played'))
            ->where('leagues.league_id', '=', $league_id)
            ->orderBy('total', 'DESC')
            ->groupBy('users.name')->paginate(10);
        $path = $request->url();
        $query = $request->query();

        $users->withPath($path . '?league_id=' . $query['league_id']);

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

        $users = User::join('predictions', 'predictions.user_id', '=', 'users.id')
            ->join('fixtures', 'fixtures.fixture_id', '=', 'predictions.fixture_id')
            ->join('leagues', 'leagues.league_id', '=', 'fixtures.league_id')
            ->select(
                'users.avatar',
                'users.name',
                'users.id',
                DB::raw('SUM(predictions.points) as total'),
                DB::raw('SUM(predictions.is_exact) as exact'),
                DB::raw('COUNT(predictions.points) as played'))
            ->where('leagues.league_id', '=', $league_id)
            ->orderBy('total', 'DESC')
            ->groupBy('users.name')->get();

        if (count($users) > 1) {
            foreach ($users as $key => $user) {
                if ($user->id == $id) {
                    $rank = $key + 1;
                }
            }
        } else {
            $rank = 0;
        }

        $user = User::join('predictions', 'predictions.user_id', '=', 'users.id')
            ->join('fixtures', 'fixtures.fixture_id', '=', 'predictions.fixture_id')
            ->join('leagues', 'leagues.league_id', '=', 'fixtures.league_id')
            ->select(
                'users.avatar',
                'users.name',
                'users.id',
                DB::raw('SUM(predictions.points) as total'),
                DB::raw('SUM(predictions.is_exact) as exact'),
                DB::raw('COUNT(predictions.points) as played'))
            ->where('leagues.league_id', '=', $league_id)
            ->where('users.id', '=', $id)
            ->orderBy('total', 'DESC')
            ->groupBy('users.name')->get();

        if (count($user) > 1) {
            $user[0]->rank = $rank;
        }

        return response()->json(['user' => $user], 200);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showCurrentUser($id)
    {

        $user = User::find($id);

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
        $request['data'] = json_decode($request['data']);

        $data = $request->all();
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($id)],
            'avatar' => ['file', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2000'],
        ]);
        $user = User::find($id);
        if ($request->file()) {
            $imageName = time() . '.' . $request->avatar->getClientOriginalExtension();
            $request->avatar->move(public_path('images/profile'), $imageName);
            $user->avatar = $imageName;

        }

        $user->name = $data['name'];
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function weeklyRankings(Request $request)
    {

        if ($request->has('league_id')) {
            $league_id = $request->input('league_id');
        }
        if ($request->has('round')) {
            $round = $request->input('round');
        }

        $users = User::join('predictions', 'predictions.user_id', '=', 'users.id')
            ->join('fixtures', 'fixtures.fixture_id', '=', 'predictions.fixture_id')
            ->join('leagues', 'leagues.league_id', '=', 'fixtures.league_id')
            ->select(
                'users.avatar',
                'users.name',
                'users.id',
                DB::raw('SUM(predictions.points) as total'),
                DB::raw('SUM(predictions.is_exact) as exact'),
                DB::raw('COUNT(predictions.points) as played'))
            ->where('leagues.league_id', '=', $league_id)
            ->where('fixtures.round', '=', $round)
            ->orderBy('total', 'DESC')
            ->groupBy('users.name')->paginate(10);
        $path = $request->url();
        $query = $request->query();

        $users->withPath($path . '?league_id=' . $query['league_id'] . '&round=' . $query['round']);

        return response()->json(['users' => $users], 200);

    }
}
