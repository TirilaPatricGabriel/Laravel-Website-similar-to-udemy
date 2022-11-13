<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request){
        $credentials = $request->validate([
            'name' => 'string|required',
            'email' => 'string|required|unique:users,email',
            'password' => 'string|required|confirmed'
        ]);

        $user = User::create([
            'name' => $credentials['name'],
            'email' => $credentials['email'],
            'password' => Hash::make($credentials['password'])
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;
        $request->session()->put('auth_token', $token);

        return response([
            'user' => $user,
            'token' => $token
        ]);
    }


    public function login(Request $request){
        $credentials = $request->validate([
            'email' => 'string|required',
            'password' => 'string|required'
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if(!$user || !Hash::check($credentials['password'], $user->password)){
            return response(['error' => 'Wrong credentials!'], 409);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        $request->session()->put('auth_token', $token);

        return response([
            'user' => $user,
            'token' => $token
        ]);
    }


    public function logout(Request $request){
        Auth::user()->tokens()->delete();
        $request->session()->forget('auth_token');

        return response(['message' => 'Logged out successfully!'], 201);
    }


    public function get_token(Request $request){
        $token = $request->session()->get('auth_token');

        return response(['token' => $token], 201);
    }
}
