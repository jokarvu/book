<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Book;
use App\User;
use App\Invoice;
use App\Import;
use App\Category;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function counter()
    {
        if (Auth::user()->isAdmin()) {
            $total_books = Book::withTrashed()->sum('quantity');
            $book_left = Book::all()->sum('quantity_left');
            $total_users = User::withTrashed()->count();
            $active_users = User::count();
            $total_invoices = Invoice::withTrashed()->count();
            $pending_invoices = Invoice::withTrashed()->where('status_id', 1)->count();
            $success_invoices = Invoice::withTrashed()->where('status_id', 4)->count();
            $total_imports = Import::withTrashed()->count();
            $total_categories = Category::count();
            $today_invoices = Invoice::whereDate('created_at', Carbon::today())->count();
            return Response::json(compact(['total_books', 'book_left', 'total_users', 'today_invoices', 'success_invoices', 'active_users', 'total_invoices', 'total_imports', 'total_categories', 'pending_invoices']), 200);
        }
        return Response::json(['message' => 'Bạn không có quyền truy cập trang này!'], 403);
    }

    public function revenue()
    {
        $invoices = DB::table('invoices')->select('invoices.id', 'book_invoice.book_id', 'book_invoice.import_id', 'book_invoice.price as sell_price', 'book_invoice.quantity', 'book_import.price as import_price', 'sell_price - import_price as reveneu')
                        ->join('book_invoice', 'invoices.id', '=', 'book_invoice.invoice_id')
                        ->join('book_import', 'book_import.import_id', 'book_invoice.import_id')
                        ->get();
        return Response::json($invoices, 200);
    }
}
