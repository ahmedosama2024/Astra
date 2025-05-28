<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Resources\Admin\UserResource;

class AuthController extends Controller
{
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
