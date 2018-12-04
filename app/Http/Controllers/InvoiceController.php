<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Invoice;
use Auth;
use App\Book;
use App\User;
use App\Http\Requests\StoreInvoiceRequest;
use Illuminate\Support\Facades\DB;

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
            $invoices = Invoice::withTrashed()->where('user_id', Auth::user()->id)
                        ->with(['books' => function ($query) {
                            $query->withTrashed()->select('name');
                        }])->get();
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
        if (Auth::user() && Auth::user()->can('create', Invoice::class)) {
            $users = User::select('username', 'id', 'address')->get();
            $books = Book::select('name', 'id', 'quantity', 'slug', 'price', 'quantity_left')->get();
            return Response::json(compact(['users', 'books']), 200);
        }
        return Response::json(['message' => 'Bạn không có quyền tạo đơn hàng'], 403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInvoiceRequest $request)
    {
        if (Auth::user() && Auth::user()->can('create', Invoice::class)) {
            $data = $request->all();
            if (isset($data['user_id'])) {
                $user = User::find($data['user_id']);
                $books = $data['carts'];
            } else {
                $user = Auth::user();
                $books = $data;
            }
            //
            if(count($books) == 0) {
                return Response::json(['message' => 'Bạn phải chọn ít nhất một đầu sách'], 422);
            }

            // Kiểm tra xem trong kho còn đủ số lượng sách không
            foreach ($books as $key => $item) {
                $book = Book::find($item['id']);
                if ($book->quantity_left < $item['quantity']) {
                    $message = 'Trong kho chỉ còn '.$book->quantity_left.' quyển '.$book->name;
                    return Response::json(['message' => $message], 422);
                }
            }
            // Tạo đơn hàng
            $invoice = Invoice::create(['user_id' => $user->id, 'address' => $user->address, 'status_id' => 1, 'shipping_tax' => 0.1]);
            foreach($books as $key => $item) {
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
        $invoice = Invoice::find($id);
        if (Auth::user() && Auth::user()->can('update', $invoice)) {
            $invoice = Invoice::withTrashed()->whereId($id)->with('books:book_id,name,slug,book_invoice.quantity,book_invoice.price')->with(['user' => function ($query) {
                $query->withTrashed()->select(['id', 'username']);
            }])->firstOrFail();
            $books = Book::all();
            return Response::json(compact(['invoice', 'books']), 200);
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
        $invoice = Invoice::find($id);
        if (Auth::user() && Auth::user()->can('update', $invoice)) {
            $data = $request->all();
            $books = $data['carts'];
            if(count($books) == 0) {
                return Response::json(['message' => 'Bạn phải chọn ít nhất một đầu sách'], 422);
            }
            // Chỉnh sửa lại số lượng sách trong kho
            $old_books_invoice = DB::table('invoices')->select('invoices.id', 'book_invoice.quantity', 'book_invoice.book_id')
                                    ->join('book_invoice', 'invoices.id', '=', 'book_invoice.invoice_id')
                                    ->where('invoices.id', '=', $id)
                                    ->get();
            if (count($old_books_invoice)) {
                foreach($old_books_invoice as $key => $value) {
                    $book = Book::find($value->book_id);
                    $book->quantity += $value->quantity;
                    $book->save();
                }
                $invoice->books()->detach();
            }
            // Kiểm tra xem trong kho còn đủ số lượng sách không
            foreach ($books as $key => $item) {
                $book = Book::find($item['id']);
                if ($book->quantity_left < $item['quantity']) {
                    return Response::json(['message' => 'Trong kho không đủ số lượng '.$book->name], 422);
                }
            }
            foreach($books as $key => $item) {
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

    public function status(Request $request, $id)
    {
        $invoice = Invoice::find($id);
        if(Auth::user() && Auth::user()->can('update', $invoice)) {
            $invoice->status_id = $request->status_id;
            $invoice->save();
            return Response::json(['message' => 'Cập nhật đơn hàng thành công'], 200);
        }
        return Response::json(['message' => 'Bạn không có quyền truy cập', 403]);
    }
}
