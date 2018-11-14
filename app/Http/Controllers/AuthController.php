<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Auth;

class AuthController extends Controller
{
    // Dang nhap
    public function login(Request $request)
    {
        // Lấy thông tin đăng nhập từ form
        $data = $request->only('email', 'password');
        if(Auth::attempt($data)) { // Thực hiện đăng nhập
            // Nếu thành công thì trả về thông báo thành công
            return Response::json(['message' => 'Đăng nhập thành công!'], 200);
        }
        // Nếu không thể đăng nhập thì thông báo lỗi
        return Response::json(['message' => 'Email hoặc mật khẩu không đúng!'], 401);
    }

    // Kiem tra admin
    public function isAdmin()
    {
        // Nếu là admin thì trả về true
        if(Auth::user() && Auth::user()->isAdmin()) { // Ham isAdmin o trong app/User.class 
            return Response::json('true', 200);
        }
        // Không phải admin thì trả về false
        return Response::json('false', 403);
    }

    // kiem tr dang nhap
    public function check()
    {
        // Neu da dang nhap tra ve true
        if(Auth::user()) {
            return Response::json('true', 200);
        }
        // Nếu chưa đăng nhập thì trả về false
        return Response::json('false', 403);
    }

    // Lay thong tin nguoi hien tai dang nhap
    public function current()
    {
        // Nếu đã đăng nhập thì trả về thông tin người dùng
        if(Auth::user()) {
            return Auth::user();
        }
        // Nếu chưa đăng nhập thì trả về false
        return Response::json('false', 403);
    }

    // Dang xuat
    public function logout()
    {
        // Nếu đã đăng nhập
        if(Auth::user()) {
            // Tiến hành đăng xuất và trả về thông báo đã đăng xuất
            Auth::logout();
            return Response::json(['message' => 'Đã đăng xuất'], 200);
        }
        // Nếu chưa đăng nhập thì thông báo chưa đăng nhập
        return Response::json(['message' => 'Bạn chưa đăng nhập'], 403);
    }
}
