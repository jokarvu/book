<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Auth;
use Illuminate\Support\Facades\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->isAdmin()) {
            $categories = Category::withTrashed()->with(['category' => function ($query) {
                $query->withTrashed();
            }])->withCount('books')->get();
        } else {
            $categories = Category::all();
        }
        return Response::json($categories, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->can('create', Category::class)) {
            $categories = Category::withTrashed()->get();
            return Response::json($categories, 200);
        }
        return Response::json(['message' => 'Bạn không có quyền tạo danh mục sách'], 403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->can('create', Category::class)) {
            $data = $request->all();
            try {
                Category::create($data);
                return Response::json(['message' => 'Tạo danh mục thành công'], 200);
            } catch(Exception $errors) {
                return Response::json(['message' => 'Không thể tạo danh mục. Vui lòng thử lại sau'], 500);
            }
        }
        return Response::json(['message' => 'Bạn không có quyền tạo mới danh mục'], 403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        if (Auth::user()->isAdmin()) {
            $category = Category::withTrashed()->where('slug', $slug)->firstOrFail();
            $books = $category->books()->get();
            $children = $category->children()->withTrashed()->withCount('books')->get();
        } else {
            $category = Category::where('slug', $slug)->firstOrFail();
            $books = $category->books()->get();
            $children = $category->children()->get();
        }
        if($category) {
            return Response::json(compact(['category', 'books', 'children']), 200);
        }
        return Response::json(['message' => 'Danh mục không tồn tại'], 404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $category = Category::withTrashed()->where('slug', $slug)->firstOrFail();
        $categories = Category::withTrashed()->get();
        if(Auth::user()->can('update', $category)) {
            return Response::json(compact(['category', 'categories']), 200);
        }
        return Response::json(['message' => 'Bạn không có quyền cập nhật danh mục'], 403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $category = Category::whereSlug($slug)->firstOrFail();
        if (Auth::user()->can('update', $category)) {
            try {
                $data = $request->all();
                $category->update($data);
                return Response::json(['message' => 'Cập nhật danh mục thành công'], 200);
            } catch (Exception $errors) {
                return Response::json(['message' => 'Có lỗi xảy ra. Vui lòng thử lại sau!'], 500);
            }
        }
        return Response::json(['message' => 'Bạn không có quyền cập nhật danh mục'], 403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if (Auth::user()->can('delete', $category)) {
            try {
                $category->children()->delete();
                $category->delete();
                return Response::json(['message' => 'Xóa danh mục thành công!'], 200);    
            } catch (Exception $errors) {
                return Response::json(['message' => 'Có lỗi xảy ra vui lòng thử lại sau!'], 500);
            }
        }
        return Response::json(['message' => 'Bạn không có quyền xóa danh mục'], 403);
    }
}
