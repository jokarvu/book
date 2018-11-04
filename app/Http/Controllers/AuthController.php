<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->only('email', 'password');
        // return $data;
        if(Auth::attempt($data)) {
            return Response::json(['message' => 'Đăng nhập thành công!'], 200);
        }
        return Response::json(['message' => 'Email hoặc mật khẩu không đúng!'], 401);
    }

    public function isAdmin()
    {
        if(Auth::user()->isAdmin()) {
            return Response::json('true', 200);
        }
        return Response::json('false', 403);
    }

    public function check()
    {
        if(Auth::user()) {
            return Response::json('true', 200);
        }
        return Response::json('false', 403);
    }

    public function current()
    {
        if(Auth::user()) {
            return Auth::user();
        }
        return Response::json('false', 403);
    }

    public function logout()
    {
        if(Auth::user()) {
            Auth::logout();
            return Response::json(['message' => 'Đã đăng xuất'], 200);
        }
        return Response::json(['message' => 'Bạn chưa đăng nhập'], 403);
    }
}
