<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $jwt_token = JWTAuth::attempt($credentials);
        $user = JWTAuth::user();
        if ($jwt_token) {
            return response()->json(['user' => $user,'token'=>$jwt_token], 200)->header('Authorization', $jwt_token);
        }
        return response()->json(['error' => 'login_error'], 401);
    }
    public function getExpireTime()
    {
        $expire= JWTAuth::parseToken()->getPayload()->get('exp');
        return response()->json(['expire' => $expire]);
    }
    public function logout()
    {
        JWTAuth::parseToken()->invalidate();
        return response()->json([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
    }

    public function refresh()
    {
        $newToken = JWTAuth::parseToken()->refresh();
        return response()->json([
            'status' => 'success',
            'msg' => $newToken
        ]);
    }
}
