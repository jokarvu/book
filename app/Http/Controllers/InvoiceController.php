<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Invoice;
use Auth;
use App\Book;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->isAdmin()) {
            $invoices = Invoice::withTrashed()->with(['user' => function ($query) {
                $query->withTrashed()->select('id', 'username');
            }])->get();
        } else {
            $invoices = Invoice::withTrashed()->where('user_id', Auth::user()->id)->get();
        }
        return Response::json($invoices, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Response::json(['message' => "Page Not Found"], 404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user() && Auth::user()->can('create', Invoice::class)) {
            $data = $request->all();
            // Kiểm tra xem trong kho còn đủ số lượng sách không
            foreach ($data as $key => $item) {
                $book = Book::find($item['id']);
                if ($book->quantity_left < $item['quantity']) {
                    return Response::json(['message' => 'Trong kho không đủ số lượng'], 422);
                }
            }
            // Tạo đơn hàng
            $invoice = Invoice::create(['user_id' => Auth::user()->id, 'address' => Auth::user()->address, 'status_id' => 1, 'shipping_tax' => 0.1]);
            // return Response::json($data);
            foreach($data as $key => $item) {
                $book = Book::find($item['id']);
                $book->quantity_left -= $item['quantity'];
                $book->save();
                $invoice->books()->attach([$item['id'] => ['quantity' => $item['quantity'], 'price' => $book->price]]);
            }
            return Response::json(['message' => 'Tạo đơn hàng thành công'], 200);
        }
        return Response::json(['message' => 'Bạn không thể tạo đơn hàng'], 403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = Invoice::withTrashed()->whereId($id)->with('books:book_id,name,slug,book_invoice.quantity,book_invoice.price')->with(['user' => function ($query) {
            $query->withTrashed()->select(['id', 'username']);
        }])->firstOrFail();
        return Response::json($invoice, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        if(Auth::user()->isAdmin()) {
            return Response::json(['message' => 'Sửa đơn hàng thành công!'], 200);
        }
        return Response::json(['message' => 'Bạn không có quyền sửa đơn hàng'], 403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice = Invoice::withTrashed()->find($id);
        if(Auth::user()->can('delete', $invoice)) {
            $invoice->delete();
            return Response::json(['message' => 'Xóa đơn hàng thành công'], 200);
        }
        return Response::json(['message' => 'Bạn không có quyền xóa đơn hàng'], 403);
    }
}
