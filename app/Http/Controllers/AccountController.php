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
        if(Auth::user() && Auth::user()->isAdmin()) {
            $users = User::with('role:id,name')->withTrashed()->get();
            return Response::json($users, 200);
        } elseif (Auth::guest()) {
            return Response::json(['messaage' => 'Bạn chưa đăng nhập'], 403);
        }   
        return Response::json(Auth::user(), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->isAdmin()) {
            $roles = Role::all();
            return Response::json($roles, 200);
        }
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
        if(Auth::guest() || Auth::user()->can('create', User::class)) {
            $data = $request->all();
            $data['password'] = bcrypt($data['password']);
            try {
                User::create($data);
                return Response::json(['message' => 'Đăng ký người dùng thành công'], 200);
            } catch(Exception $errors) {
                return Response::json(['message' => 'Không thể tạo người dùng. Vui lòng thử lại sau'], 500);
            }
        }
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
        $user = User::withTrashed()->where('username', $slug)->with('role:id,name')->first();
        if (Auth::user()->can('view', $user)) {
            return Response($user, 200);
        }
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
        $user = User::withTrashed()->where('username', $slug)->firstOrFail();
        if(Auth::user()->can('update', $user)) {
            if(Auth::user()->isAdmin()) {
                $roles = Role::all();
                return Response::json(compact(['roles', 'user']), 200);
            }
            return Response::json($user, 200);
        }
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
        $user = User::withTrashed()->where('username', $slug)->firstOrFail();
        if(Auth::user()->can('update', $user)) {
            $user->username = $request->username;
            $user->address = $request->address;
            $user->email = $request->email;
            $user->save();
            return Response::json(['message' => 'Cập nhật người dùng thành công'], 200);
        }
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
        $user = User::find($id);
        if (Auth::user()->can('delete', $user)) {
            $user->delete();
            return Response::json(['message' => 'Xóa người dùng thành công!'], 200);
        }
        return Response::json(['message' => 'Bạn không có quyền xóa người dùng'], 403);
    }
}
