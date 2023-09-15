<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Passport\Passport;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);

        if (!auth()->attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = auth()->user();
        $token = $user->createToken('MyApp')->accessToken;

        return response()->json(['access_token' => $token]);
    }


    public function register(Request $request)
    {

        return response()->json(['message' => 'Registration successful'], 201);
    }

}

