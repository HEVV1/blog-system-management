<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(AuthRequest $request): JsonResponse
    {
        $validate = $request->validated();

        $user = User::create([
            'name' => $validate['name'],
            'email' => $validate['email'],
            'password' => Hash::make($validate['password']),
        ]);

        $user->sendEmailVerificationNotification();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Account has been created',
            'user' => $user->makeHidden(['password', 'remember_token']),
            'token' => $token
        ], 201);
    }

    public function login(AuthRequest $request)
    {
        $validate = $request->validated();

        $user = User::where('email', $validate['email'])->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => 'provided credentials aren\'t valid'
            ]);
        }

        if (!Hash::check($validate['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => 'provided credentials aren\'t valid'
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'You logged in successfully',
            'user' => $user->makeHidden(['password', 'remember_token']),
            'token' => $token,
        ], 200);
    }

    public function logout()
    {
        Auth::user()->tokens->each(function ($token) {
            $token->forceDelete();
        });

        return response()->json([
            'message' => 'Logged out successfully'
        ], 200);
    }
}
