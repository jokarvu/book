<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Import;
use App\Book;
use Auth;
use App\Supplier;

class ImportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user() && Auth::user()->isAdmin()) {
            $imports = Import::withTrashed()->with('supplier:id,name')->get();
            return Response::json($imports, 200);
        }
        return Response::json(['message' => 'Bạn không có quyền xem thông tin nhập hàng'], 403);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user() && Auth::user()->can('create', Import::class)) {
            $suppliers = Supplier::withTrashed()->get();
            $books = Book::withTrashed()->get();
            return Response::json(compact(['suppliers', 'books']), 200);
        }
        return Response::json(['message' => 'Bạn không có quyền nhập hàng'], 403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user() && Auth::user()->can('create', Import::class)) {
            $data = $request->all();
            $supplier_id = $data['supplier_id'];
            $note = $data['note'];
            $books = $data['books'];
            if (!count($books)) {
                return Response::json(['message' => 'Đơn hàng phải nhập ít nhất 1 đầu sách'], 422);
            }
            $imports = Import::create(['supplier_id' => $supplier_id, 'note' => $note]);
            foreach ($books as $key => $item) {
                $book = Book::find($item['id']);
                $book->quantity += $item['quantity'];
                $book->quantity_left += $item['quantity'];
                $book->save();
                $imports->books()->attach([$item['id'] => ['quantity' => $item['quantity'], 'price' => $item['price']]]);
            }
            return Response::json(['message' => 'Tạo hóa đơn nhập thành công!'], 200);
        }
        return Response::json(['message' => 'Bạn không có quyền nhập hàng'], 403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $import = Import::find($id);
        if (Auth::user() && Auth::user()->can('view', $import)) {
            $import = Import::with('books:book_id,name,book_import.quantity,book_import.price')->with('supplier')->whereId($id)->firstOrFail();
            return Response::json($import, 200);
        }
        return Response::json(['message' => 'Bạn không có quyền xem mục này'], 403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Repsonse::json(['message' => 'Đang xây dựng'], 404);
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
        return Response::json(['message' => 'Đang xây dựng'], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $import = Import::find($id);
        if (Auth::user() && Auth::user()->can('delete', $import)) {
            $import->delete();
            return Response::json(['message' => 'Xóa hóa đơn nhập hàng thành công'], 200);
        }
        return Response::json(['message' => 'Bạn không có quyền truy cập'], 403);
    }
}
