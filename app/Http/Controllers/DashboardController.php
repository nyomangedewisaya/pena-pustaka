<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalFine = Transaction::sum('fine');
        $countCategories = Category::count();
        $countBooks = Book::count();
        $countUsers = User::where('role', 'student')->count();
        $countTransactions = Transaction::count();

        $lowestStockBook = Book::with('category')
            ->where('stock', '<=', 5)->orderBy('stock', 'asc')
            ->limit(5)->get();

        $newestTransactions = Transaction::with(['user', 'book'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('pages.admin.dashboard', compact(
            'totalFine',
            'countCategories', 
            'countBooks', 
            'countUsers', 
            'countTransactions', 
            'lowestStockBook', 
            'newestTransactions')
        );
    }
}
