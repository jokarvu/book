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
        // Nếu là admin thì lấy danh sách các sách có trong cửa hàng kể cả các sách trong thùng rác
        if (Auth::user() && Auth::user()->isAdmin()) {
            // Lấy danh sách sách bao gồm cả sách trong thùng rác kèm theo là danh mục của sách
            $books= Book::withTrashed()->with(['category' => function ($query) {
                $query->withTrashed();
            }])->get();
        } else { 
            // Nếu chỉ là khách hoặc người dùng bình thường thì lấy ra danh sách sách (không bao gồm sách trong thùng rác)
            $books = Book::select('id', 'slug', 'quantity', 'quantity_left', 'name', 'price')->get();
        }
        // Trả về response danh sách sách cho client
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
        if(Auth::user() && Auth::user()->can('create', Book::class)) {
            // Lấy ra danh sách danh mục (không bao gồm danh mục đã bị xóa)
            $categories = Category::all();
            // Trả về response cho client
            return Response::json($categories, 200);
        }
        // Nếu không phải admin thì không có quyền truy cập trang này
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
        // Nếu có quyền tạo danh mục mới (là admin)
        if(Auth::user() && Auth::user()->can('create', Book::class)) {
            // Lấy thông tin sách ngoại trừ hình ảnh mô tả
            $data = $request->except('thumbnail');
            $data['quantity'] = 0;
            $data['quantity_left'] = $data['quantity'];
            try {
                // Tên ảnh của sách sẽ có dạng slug.jpg (ví dụ: thang-quy-nho.jpg)
                $thumbnail = str_slug($data['name']).'.jpg';
                // Lưu ảnh với tên ở trên
                $path = $request->file('thumbnail')->storeAs('product', $thumbnail, 'public');
                //  Tạo sách
                Book::create($data);
                // Trả về response thông báo thành công
                return Response::json(['message' => 'Thêm sách thành công!'], 200);
            } catch (Exception $errors) {
                // Nếu xảy ra lỗi thì trả về response thông báo lỗi 
                return Response::json(['message' => 'Có lỗi xảy ra. Không thể tạo sách!'], 500);
            }
        }
        // Nếu không có quyền tạo sách mới thì trả về response thông báo bạn không có quyền tạo sách
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
        // Nếu là admin thì có quyền xem thông tin cả sách đã xóa
        if (Auth::user() && Auth::user()->isAdmin()) {
            // Lấy danh sách sách kể cả đã bị xóa 
            $book = Book::withTrashed()->whereSlug($slug)->with(['category' => function ($query) {
                $query->withTrashed();
            }])->firstOrFail();
        } else {
            // Nếu không phải admin thì lấy ra thông tin sách (không tính sách đã xóa)
            $book = Book::whereSlug($slug)->firstOrFail();
        }
        // Nếu có sách thì trả về thông tin sách
        if($book) {
            return Response::json($book, 200);
        }
        // Nếu không có sách thì trả về response thông báo sách không tồn tại
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
        // Lấy thông tin sách muốn sửa (có slug là $slug)
        $book = Book::withTrashed()->where('slug', $slug)->firstOrFail();
        // Nếu có quyền sửa sách (là admin)
        if(Auth::user() && Auth::user()->can('update', $book)) {
            // Lấy ra danh sách danh mục để hiển thị trên form sửa sách
            $categories = Category::all();
            // Trả về respone gồm thông tin sách và danh sách danh mục
            return Response::json(compact(['categories', 'book']), 200);
        }
        // Nếu không có quyền sửa thì trả về response không có quyền sửa sách
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
        // Lấy ra sách cần sửa
        $book = Book::withTrashed()->where('slug', $slug)->firstOrFail();
        // Nếu người dùng có quyền sửa
        // return $request->all();
        if(Auth::user() && Auth::user()->can('update', $book)) {
            // Sửa sách 
            $data = $request->except(['sold', 'thumbnail', '_method', 'deleted_at', 'created_at', 'updated_at']);
            try {
                // Xử lý tên ảnh
                if ($request->file('thumbnail')) {
                    $thumbnail = str_slug($data['name']).'.jpg';
                    // Lưu ảnh
                    $path = $request->file('thumbnail')->storeAs('product', $thumbnail, 'public');
                }
                $data['quantity_left'] += $data['quantity'] - $book->quantity;
                // Lưu thông tin chỉnh sửa
                Book::withTrashed()->where('slug', $slug)->update($data);
                // Trả về response thông báo cập nhật thành công
                return Response::json(['message' => 'Cập nhật sách thành công!'], 200);
            } catch(Exception $errors) {
                // Xảy ra lỗi thì trả về thông báo có lỗi xảy ra
                return Response::json(['message' => 'Có lỗi xảy ra. Vui lòng thử lại sau'], 500);
            }
        }
        // Nếu không có quyền sửa thì trả về response không có quyền truy cập
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
        if (Auth::user() && Auth::user()->can('delete', $book)) {
            $book->delete();
            return Response::json(['message' => 'Đã xóa sách thành công'], 200);
        }
        return Response::json(['message' => 'Bạn không có quyền xóa sách'], 403);
    }

    public function latest() {
        $books = Book::select('name', 'slug', 'quantity', 'quantity_left', 'id', 'price')->orderBy('created_at', 'desc')->take(8)->get();
        return Response::json($books, 200);
    }

    public function popular() {
        $books = Book::with('category:name,id')->orderByRaw('quantity - quantity_left DESC')->take(8)->get();
        return Response::json($books, 200);
    }
}
