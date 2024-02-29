<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    public function register(Request $request)
    {
        $registerUserData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password'
        ]);
        $user = User::create([
            'name' => $registerUserData['name'],
            'email' => $registerUserData['email'],
            'password' => Hash::make($registerUserData['password']),
        ]);
        return response()->json([
            'message' => 'User Created ',
        ]);
    }

    public function login(Request $request)
    {
        $loginUserData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|min:8'
        ]);
        $user = User::where('email', $loginUserData['email'])->first();
        if (!$user || !Hash::check($loginUserData['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid Credentials'
            ], 401);
        }
        $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'user' => $user
        ]);
    }

    public function logout(Request $request)
    {
        // Get user who requested the logout
        $user = request()->user(); //or Auth::user()

        // Revoke all tokens...
        $user->tokens()->delete();
        // $user->tokens()->delete();
        return response()->json([
            'message' => 'Logged Out',
            'user' => $user
        ]);
    }

    public function refreshToken(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'user' => $user
        ]);
    }

}
