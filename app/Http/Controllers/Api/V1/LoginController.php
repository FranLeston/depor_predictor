<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    use RegistersUsers;

    public function login(Request $request)
    {

        $login = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($login)) {
            return response()->json(['message' => 'Invalid Login credentials.'], 401);
        }

        $accessToken = Auth::user()->createToken('authToken')->accessToken;
        return response()->json(['user' => Auth::user(), 'accessToken' => $accessToken], 200);
    }

    public function register(Request $request)
    {

        $data = $request->all();
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'avatar' => 'https://www.iconfinder.com/data/icons/avatars-55/100/avatar_profile_user_music_headphones_shirt_cool-512.png',
        ]);
        return response()->json(['user' => $user], 200);
    }

    public function logout()
    {
        DB::table('oauth_access_tokens')
            ->where('user_id', Auth::user()->id)
            ->update([
                'revoked' => true,
            ]);
        return response()->json(['message' => "Successfully logged out."], 200);
    }
}
