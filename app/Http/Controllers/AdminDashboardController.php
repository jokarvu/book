<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
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
            $total_invoices = Invoice::count();
            $pending_invoices = Invoice::where('status_id', 1)->count();
            $success_invoices = Invoice::where('status_id', 4)->count();
            $total_imports = Import::withTrashed()->count();
            $total_categories = Category::count();
            $today_invoices = Invoice::whereDate('created_at', Carbon::today())->count();
            return Response::json(compact(['total_books', 'book_left', 'total_users', 'today_invoices', 'success_invoices', 'active_users', 'total_invoices', 'total_imports', 'total_categories', 'pending_invoices']), 200);
        }
        return Response::json(['message' => 'Bạn không có quyền truy cập trang này!'], 403);
    }
}
