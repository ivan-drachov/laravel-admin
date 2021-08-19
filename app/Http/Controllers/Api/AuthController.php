<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password'))){
            $user = Auth::user();
            $token = $user->createToken('admin')->accessToken;
            $cookie = \cookie('jwt', $token, 3600);
            return \response([
                'token' => $token,
            ])->withCookie($cookie);
        }
        return response([
            'error' => 'Invalid Credentials!',
        ], 401);
    }

    public function logout()
    {
        $cookie = \Cookie::forget('jwt');
        return \response([
            'message' => 'success'
        ])->withCookie($cookie);
    }

    public function register(RegisterRequest $request)
    {

        $user = User::create($request->only('first_name', 'last_name', 'email')+['password' => Hash::make($request->input('password'))]+['role_id'=> $request->input('role_id')]);
        //dd($user);
        return response($user, 201);
    }
}
