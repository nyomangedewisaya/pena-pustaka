<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookCatalogController extends Controller
{
    public function index(Request $request) {
        $query = Book::with('category')->orderBy('title', 'asc');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            }); 
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $data = $query->get();
        $categories = Category::orderBy('name', 'asc')->get();
        
        return view('pages.users.catalog.book_catalog', compact('data', 'categories'));
    }

    public function show($id) {
        $book = Book::with(['category', 'reviews.user'])->findOrFail($id);
        $avgRating = $book->reviews()->avg('rating');

        return view('pages.users.catalog.book_detail', compact('book', 'avgRating'));
    }

    public function borrow(Request $request) {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id'
        ]);

        $userId = Auth::id();
        $bookId = $request->book_id;
        $book = Book::findOrFail($bookId);

        if ($book->stock <= 0) {
            return back()->with('error', 'Maaf, buku ini stok nya sedang kosong!');
        }
        
        $isBorrowing = Transaction::where('user_id', $userId)->where('book_id', $bookId)->where('status', 'borrowed')->exists();
        
        if ($isBorrowing) {
            return back()->with('error', 'Buku ini sedang Anda pinjam dan Anda belum mengembalikannya!');
        }

        try {
            DB::beginTransaction();

            Transaction::create([
                'user_id' => $userId,
                'book_id' => $validated['book_id'],
                'loan_date' => Carbon::now(),
                'late_date' => Carbon::now()->addDays(7),
                'status' => 'borrowed'
            ]);

            $book->decrement('stock');

            DB::commit();

            return redirect()->route('transactions.user')->with('success', 'Buku berhasil dipinjam! silakan ambil buku di Perpustakaan.');
        }
        catch(\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem, silakan coba lagi.');
        }
    }
}
