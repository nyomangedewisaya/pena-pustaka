<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionUserController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $borrowedTransactions = Transaction::with('book.category')->where('user_id', $userId)->whereIn('status', ['borrowed', 'pending'])->orderBy('loan_date', 'desc')->get();
        $returnedTransactions = Transaction::with('book.category')->where('user_id', $userId)->whereIn('status', ['returned', 'late'])->orderBy('return_date', 'desc')->get();

        $reviewedBookIds = Review::where('user_id',$userId)->pluck('book_id')->toArray();

        return view('pages.users.transactions.history', compact('borrowedTransactions', 'returnedTransactions', 'reviewedBookIds'));
    }

    public function review(Request $request) {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:200'
        ]);

        $userId = Auth::id();
        $bookId = $request->book_id;

        $existingReview = Review::where('user_id', $userId)->where('book_id', $bookId)->exists();

        if ($existingReview) {
            return back()->with('error', 'Anda sudah pernah mengulas buku ini!');
        }

        Review::create([
            'user_id' => $userId,
            'book_id' => $validated['book_id'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return back()->with('success', 'Ulasan berhasil dikirim!');
    }

    public function return(Transaction $transaction) {
        $now = Carbon::now();

        $transaction->return_date = $now;
        $transaction->status = 'pending';
        $transaction->save();

        return back()->with('success', 'Buku berhasil dikembalikan, menunggu persetujuan Admin.');
    }
}
