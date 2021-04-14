<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function profile(Request $request)
    {
        $user = Auth::user();
        $user = $this->getUserProfile($user);
        return $user;
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (!Auth::attempt($loginData)) {
            return response([
                'status' => false,
                'error' => 'Invalid Credentials'
            ], 401);
        }
        $accessToken = Auth::user()->createToken('authToken')->accessToken;
        $user = Auth::user();
        $user = $this->getUserProfile($user);

        return response(['user' => $user, 'access_token' => $accessToken]);
    }

    private function getUserProfile(User $user)
    {
        $user->load('role');
        if ($user->role_type == 'Driver')
        {
            $user->load('role.transportation');
        }
        return $user;
    }
}
