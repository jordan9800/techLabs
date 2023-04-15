<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
   
    public function register(RegisterRequest $request)
    {
        $fields = $request->all();

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('assignment')->plainTextToken;

        return response(['user' => $user, 'token' => $token], 201);
    }

    public function login(LoginRequest $request)
    {
        //Check Email
        $user = User::where('email', $request['email'])->first();

        if(!$user && !Hash::check($request['password'], $user->password)) {
            return response(['message' => 'Invalid Login Credentials!'], 401);
        }

        $token = $user->createToken('assignment')->plainTextToken;

        return response(['user' => $user, 'token' => $token], 200);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return response(['message' => 'Logged out!'], 200);
    }
}
