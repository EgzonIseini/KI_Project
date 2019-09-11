<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequests\LoginRequest;
use App\Http\Requests\AuthRequests\RegisterRequest;
use App\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {

        $data['password'] = bcrypt($request->get('password'));
        $data['first_name'] = $request->get('first_name');
        $data['last_name'] = $request->get('last_name');
        $data['email'] = $request->get('email');

        $user = User::create($data);
        $accessToken = $user->createToken('authToken')->accessToken;
        return response(['user' => $user, 'access_token' => $accessToken]);
    }

    public function login(LoginRequest $request)
    {
        $data['email'] = $request->get('email');
        $data['password'] = $request->get('password');

        if (!auth()->attempt($data)) {
            return response(['message' => 'Invalid credentials']);
        }
        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        return response(['user' => auth()->user(), 'access_token' => $accessToken]);

    }
}
