<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Auth;
use App\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Auth::user() là hàm trả về thông tin người dùng đang đăng nhập (nếu chưa đăng nhập trả về null) (tự có)
        // Auth::user()->isAdmin() là hàm kiểm tra quyền admin (tệp app\User.php)
        // Kiểm tra người dùng đã đăng nhập và là admin
        if (Auth::user() && Auth::user()->isAdmin()) {
            // Lấy tất cả quyền (tệp app\Role)
            $roles = Role::all();
            // Trả về tất cả các quyền
            return Response::json($roles, 200);
        }
        // Nếu người dùng chưa đăng nhập hoặc không phải admin thì trả về lỗi
        return Response::json(['message' => 'Bạn không có quyền truy cập'], 403);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Không cần đến nên trả về lỗi luôn
        return Response::json(['message' => 'Trang này không tồn tại'], 404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Auth::user() là hàm trả về thông tin người dùng đang đăng nhập (nếu chưa đăng nhập trả về null) (tự có)
        // Auth::user()->can('create', Role::class) là hàm kiếm tra nếu người dùng có quyền tạo role mới
        if (Auth::user() && Auth::user()->can('create', Role::class)) {
            // Lấy tên quyền cần tạo mới từ request của người dùng
            $data = $request->only('name');
            // Tiến hành tạo người dùng
            try {
                $roles = Role::create($data);
                // Tạp thành công thì trả về thành công
                return Response::json(['message' => 'Thêm quyền thành công'], 200);
            } catch (Exception $errors) {
                // Gặp lỗi thông báo lỗi 
                return Response::json(['message' => "Có lỗi xảy ra. Vui lòng thử lại sau"], 500);
            }
        }
        // Nếu không có quyền truy cập thì thông báo lỗi
        return Response::json(['message' => 'Bạn không có quyền truy cấp'], 403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        // Lấy 
        $role = Role::whereSlug($slug)->firstOrFail();
        if (Auth::user() && Auth::user()->can('view', $role)) {
            return Response::json($role, 200);
        }
        return Response::json(['message' => 'Bạn không có quyền truy cập'], 403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::whereSlug($slug)->firstOrFail();
        if (Auth::user() && Auth::user()->can('update', $role)) {
            return Response::json($role);
        }
        return Response::json(['message' => 'Bạn không có quyền truy cập'], 403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        if (Auth::user() && Auth::user()->can('update', $role)) {
            $data = $request->only('name');
            try {
                $role->name = $data['name'];
                $role->slug = str_slug($data['name']);
                $role->save();
                return Response::json(['message' => 'Cập nhật thành công!'], 200);
            } catch(Exception $errors) {
                return Response::json(['message' => 'Có lỗi xảy ra. Vui lòng thử lại sau'], 500);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        if (Auth::user() && Auth::user()->can('delete', $role)) {
            $role->delete();
            return Response::json(['message' => 'Đã xóa quyền và toàn bộ user có quyền'], 200);
        }
        return Response::json(['message' => 'Bạn không có quyền xóa'], 403);
    }
}
