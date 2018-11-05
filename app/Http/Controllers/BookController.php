<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\Category;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\StoreBookRequest;
use Auth;
use App\Http\Requests\UpdateBookRequest;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->isAdmin()) {
            $books= Book::withTrashed()->with('category:id,name')->get();
        } else { 
            $books = Book::all();
        }
        return Response::json($books, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Chỉ admin mới có quyền tạo sách mới
        if(Auth::user()->can('create', Book::class)) {
            $categories = Category::all();
            return Response::json($categories, 200);
        }
        return Response::json(['message' => 'Bạn không có quyền truy cập trang này', 403]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookRequest $request)
    {
        if(Auth::user()->can('create', Book::class)) {
            $data = $request->except('thumbnail');
            try {
                $thumbnail = str_slug($data['name']).'.jpg';
                $path = $request->file('thumbnail')->storeAs('product', $thumbnail, 'public');
                Book::create($data);
                return Response::json(['message' => 'Thêm sách thành công!'], 200);
            } catch (Exception $errors) {
                return Response::json(['message' => 'Có lỗi xảy ra. Không thể tạo sách!'], 500);
            }
        }
        return Response::json(['message' => 'Bạn không có quyền tạo sách mới!'], 403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $book = Book::withTrashed()->where('slug', $slug)->with('category:id,name')->withCount('invoices')->firstOrFail();
        if ($book) {
            return Response::json($book, 200);
        }
        return Response::json(['message' => 'Sách không tồn tại'], 404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $book = Book::withTrashed()->where('slug', $slug)->firstOrFail();
        $categories = Category::all();
        if(Auth::user()->can('update', $book)) {
            return Response::json(compact(['categories', 'book']), 200);
        }
        return Response::json(['message' => 'Bạn không có quyền sửa sách'], 403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBookRequest $request, $slug)
    {
        $book = Book::withTrashed()->where('slug', $slug)->firstOrFail();
        if(Auth::user()->can('update', $book)) {
            $data = $request->input('name');
            return $data;
            try {
                $thumbnail = str_slug($data['name']).'.jpg';
                $path = $request->file('thumbnail')->storeAs('product', $thumbnail, 'public');
                Book::withTrashed()->where('slug', $slug)->update($data);
                return Response::json(['message' => 'Cập nhật sách thành công!'], 200);
            } catch(Exception $errors) {
                return Response::json(['message' => 'Có lỗi xảy ra. Vui lòng thử lại sau'], 500);
            }
        }
        return Response::json(['message' => 'Bạn không có quyền cập nhật sách!'], 403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::withTrashed()->find($id);
        if (Auth::user()->can('delete', $book)) {
            // Tạm thời chưa sử lý được vì lỗi 'updated_at' ambiguous
            // $book->imports()->delete()->withoutTimestamps();
            // $book->invoices()->delete();
            $book->delete();
            return Response::json(['message' => 'Đã xóa sách thành công'], 200);
        }
        return Response::json(['message' => 'Bạn không có quyền xóa sách'], 403);
    }
}
