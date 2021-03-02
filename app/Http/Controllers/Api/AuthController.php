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

        if(!$jwt_token){
            return response()->json(['errors' =>'invalid email or password'],422);
        }
        $data = [
            'token' => $jwt_token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ];
        $user = JWTAuth::user()->toArray();
        $data = array_merge($data,$user);
        return response($data, 200);
//        if ($jwt_token) {
//            return response()->json(['user' => $user,'token'=>$jwt_token], 200)->header('Authorization', $jwt_token);
//        }
//
//        return response()->json(['error' => 'login_error'], 401);
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
