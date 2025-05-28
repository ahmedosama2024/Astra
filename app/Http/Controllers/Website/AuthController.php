<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\LoginRequest;
use App\Http\Requests\Website\SignupRequest;
use App\Http\Resources\Website\UserResource;

class AuthController extends Controller
{
    public function signup(SignupRequest $request)
    {
        $user = $request->signup();
        $token = $user->createToken($user->name)->accessToken;

        return response([
            'message' => __('auth.signup'),
            'user' => new UserResource($user),
            'access_token' => $token,
        ]);
    }

    public function login(LoginRequest $request)
    {
        $user = $request->login();
        $token = $user->createToken($user->name)->accessToken;
        
        return response([
            'message' => __('auth.login'),
            'user' => new UserResource($user),
            'access_token' => $token,
        ]);
    }

    public function logout()
    {
        auth('api')->user()->token()->revoke();

        return response([
            'message' => __('auth.logout'),
        ]);
    }
}
