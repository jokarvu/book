<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\User;
use Auth;
use App\Role;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Nếu đã đăng nhập và là admin thì lấy ra tất cả user kể cả các user đã xóa (thùng rác)
        if(Auth::user() && Auth::user()->isAdmin()) {
            // Lấy tất cả user kể cả các user đã xóa (trong thùng rác) kèm theo role của user
            $users = User::with('role:id,name')->withTrashed()->get();
            // Trả về response cho client
            return Response::json($users, 200);
        } elseif (Auth::guest()) {
            // Nếu là khách thì thông báo chưa đăng nhập
            return Response::json(['messaage' => 'Bạn chưa đăng nhập'], 403);
        }
        // Nếu đã đăng nhập thì trả về thông tin tài khoản đang đăng nhập
        return Response::json(Auth::user(), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Nếu là tài khoản admin thì lấy danh sách role
        if(Auth::user()->isAdmin()) {
            // Lấy danh sách các role để tao người dùng
            $roles = Role::all();
            // Trả về danh sách role để hiển thị form tạo người dùng
            return Response::json($roles, 200);
        }
        // Nếu không phải admin (tức là không có quyền tạo mới người dùng với các role khác nhau) trả về lỗi
        // Ở đây admin có thể tạo được người dùng mang quyền admin
        //  Khách hàng chỉ có thể tạo tài khoản thông thường
        return Response::json(['message' => 'Page Not Found'], 404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        // Nếu là khách hoặc admin thì có quyền tạo mới người dùng
        if(Auth::guest() || Auth::user()->can('create', User::class)) {
            // Lấy thông tin đăng ký
            $data = $request->all();
            // Mã hóa mật khẩu
            $data['password'] = bcrypt($data['password']);
            // Tiến hành tạo người dùng
            try {
                User::create($data);
                // Tạo thành công thì trả về response thông báo cho client
                return Response::json(['message' => 'Đăng ký người dùng thành công'], 200);
            } catch(Exception $errors) {
                // Nếu quá trình tạo xảy ra lỗi thì trả về response không thể tạo người dùng
                return Response::json(['message' => 'Không thể tạo người dùng. Vui lòng thử lại sau'], 500);
            }
        }
        // Nếu không có quyền tạo mới (không phải khách hoặc admin - đã đăng nhập nhưng là tài khoản thông thường)
        // thì trả về repsonse không có quyền tạo mới người dùng
        return Response::json(['message' => 'Bạn không có quyền tạo mới người dùng'], 403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        // Lấy ra thông tin người dùng có username là $slug
        $user = User::withTrashed()->where('username', $slug)->with('role:id,name')->firstOrFail();
        // Nếu người dùng hiện tại có quyền xem thông tin của $user có username là $slug
        if (Auth::user() && Auth::user()->can('view', $user)) {
            // Trả về thông tin người dùng
            return Response($user, 200);
        }
        // Nếu không có quyền xem (không phải admin hoặc $user không phải người dùng đang đăng nhập) trả về response thông báo lỗi
        return Response::json(['message' => 'Bạn không có quyền xem người dùng này'], 403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        // Lấy ra thông tin người dùng cần chỉnh sửa
        $user = User::withTrashed()->where('username', $slug)->firstOrFail();
        // Nếu người dùng đang đăng nhập có quyền sửa $user
        if(Auth::user() && Auth::user()->can('update', $user)) {
            // Nếu là admin thì có quyền sửa cả role của $user
            if(Auth::user()->isAdmin()) {
                // Lấy ra các role để hiển thị form
                $roles = Role::all();
                // Trả về response gồm danh sách role và thông tin $user
                return Response::json(compact(['roles', 'user']), 200);
            }
            // Nếu không phải admin và đang đăng nhập => trả về response chỉ gồm thông tin $user
            return Response::json($user, 200);
        }
        // Nếu không đăng nhập thì trả về response không có quyền sửa $user
        return Response::json(['message' => 'Bạn không có quyền sửa người dùng này'], 403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $slug)
    {
        // Lấy ra thông tin người dùng có username là $slug
        $user = User::withTrashed()->where('username', $slug)->firstOrFail();
        if(Auht::user() && Auth::user()->can('update', $user)) {
            // Update thông tin user
            $user->username = $request->username;
            $user->address = $request->address;
            $user->email = $request->email;
            // Lưu sửa đổi
            $user->save();
            // Trả về response thông báo thành công
            return Response::json(['message' => 'Cập nhật người dùng thành công'], 200);
        }
        // Nếu không phải admin thì trả về response không có quyền sửa
        return Response::json(['message' => 'Bạn không có quyền sửa người dùng này'], 403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Lấy ra người dùng có id là $id
        $user = User::find($id);
        // Nếu người dùng đang đăng nhập có quyền xóa người dùng (là admin)
        if (Auth::user() && Auth::user()->can('delete', $user)) {
            // Xóa người dùng
            $user->delete();
            // Trả về response thông báo xóa thành công
            return Response::json(['message' => 'Xóa người dùng thành công!'], 200);
        }
        // Nếu không có quyền xóa người dùng thì trả về response không có quyền xóa người dùng
        return Response::json(['message' => 'Bạn không có quyền xóa người dùng'], 403);
    }
}
