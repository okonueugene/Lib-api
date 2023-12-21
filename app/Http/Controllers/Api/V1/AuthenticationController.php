<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $token = Auth::user()->createToken('authToken')->plainTextToken;

        return response()->json([
            'message' => 'Successfully logged in use the token below to authenticate your requests',
            'user' => auth()->user(),
            'token' => $token]);

    }

    public function logout()
    {

        if (Auth::check()) {
            Auth::user()->tokens()->delete();

            return response()->json(['message' => 'Successfully logged out']);
        }

        return response()->json(['message' => 'Not authenticated'], 401);

    }

}