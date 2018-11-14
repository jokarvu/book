<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Supplier;
use Auth;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user() && Auth::user()->isAdmin()) {
            $suppliers = Supplier::withTrashed()->get();
            return Response::json($suppliers, 200);
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
        return Response::json(['message' => 'Trang không tồn tại'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user() && Auth::user()->can('create', Supplier::class)) {
            $data = $request->all();
            try {
                $supplier = Supplier::create($data);
                return Response::json(['message' => 'Tạo nhà cung cấp thành công'], 200);
            } catch(Exception $errors) {
                return Response::json(['message' => 'Có lỗi xảy ra. Vui lòng thử lại sau'], 500);
            }
        }
        return Response::json(['message' => 'Bạn không có quyền truy cập'], 403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $supplier = Supplier::whereSlug($slug)->firstOrFail();
        if (Auth::user() && Auth::user()->can('view', $supplier)) {
            return Response::json($supplier, 200);
        }
        return Repsonse::json(['message' => 'Bạn không có quyền truy cập'], 403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $supplier = Supplier::whereSlug($slug)->firstOrFail();
        if (Auth::user() && Auth::user()->can('update', $supplier)) {
            return Response::json($supplier, 200);
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
        $supplier = Supplier::find($id);
        if (Auth::user() && Auth::user()->can('update', $supplier)) {
            $data = $request->only('name');
            try {
                $supplier->name = $data['name'];
                $supplier->slug = str_slug($data['name']);
                $supplier->save();
                return Response::json(['message' => 'Đã cập nhật thành công'], 200);
            } catch (Exceptio $errors) {
                return Response::json(['message' => 'Có lỗi xảy ra. Vui lòng thử lại sau'], 500);
            }
        }
        return Response::json(['message' => 'Bạn không có quyền truy cập'], 403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = Supplier::find($id);
        if (Auth::user() && Auth::user()->can('delete', $supplier)) {
            $supplier->delete();
            return Repsonse::json(['message' => 'Đã xóa nhà cung cấp'], 200);
        }
        return Response::json(['message' => 'Bạn không có quyền truy cập'], 403);
    }
}
