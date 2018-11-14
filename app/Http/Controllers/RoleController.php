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
        if (Auth::user() && Auth::user()->isAdmin()) {
            $roles = Role::all();
            return Response::json($roles, 200);
        }
        return Response::json(['message' => 'Bạn không có quyền truy cập'], 403);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        if (Auth::user() && Auth::user()->can('create', Role)) {
            $data = $request->only('name');
            try {
                $roles = Role::create($data);
                return Response::json(['message' => 'Thêm quyền thành công'], 200);
            } catch (Exception $errors) {
                return Response::json(['message' => "Có lỗi xảy ra. Vui lòng thử lại sau"], 500);
            }
        }
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
