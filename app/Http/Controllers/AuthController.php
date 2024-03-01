<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request)
    {
        $request->validated();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('API token',['*'],now()->addWeek())->plainTextToken;

        $data = [
            'user' => $user,
            'token' => $token,
        ];

        return response()->json($data, 201);
    }

    public function login(LoginUserRequest $request){
        $request->validated();

        //$user = User::where('email', $request->email)->first();

        if (!auth()->attempt($request->only('email', 'password'))) {
            return response()->json(["message" => "Invalid credentials"], 401);
        }

        $user = auth()->user();
        $token = $user->createToken('API token',['*'],now()->addWeek())->plainTextToken;
        $data = [
            'user' => $user,
            'token' => $token,
        ];

        return response()->json($data, 200);
    }

    public function logout()
    {
        //auth()->user()->tokens()->delete();
        auth()->user()->currentAccessToken()->delete();

        return response()->json(["message" => "Logged out successfully"], 200);
    }

}
