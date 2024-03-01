<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        if (! auth()->attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details',
            ], 401);
        }

        $token = auth()->user()->createToken('token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'token' => $token,
        ], 201);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout successful',
        ], 201);
    }
}
