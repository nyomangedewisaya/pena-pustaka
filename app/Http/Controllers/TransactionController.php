<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request) {
        $borrowedTransactions = Transaction::with(['book', 'user'])->where('status', 'borrowed')->latest()->get();
        $approvedTransactions = Transaction::with(['book', 'user'])->where('status', 'pending')->latest()->get();
        $queryAllTransactions = Transaction::with(['book', 'user'])->latest();

        if ($request->filled('status')) {
            $queryAllTransactions->where('status', $request->status);
        }

        if ($request->filled('condition')) {
            $queryAllTransactions->where('condition', $request->condition);
        }

        $allTransactions = $queryAllTransactions->get();

        return view('pages.admin.transactions.index', compact('borrowedTransactions', 'approvedTransactions', 'allTransactions'));
    }

    public function create() {
        $books = Book::where('stock', '!=', 0)->orderBy('title', 'asc')->get();
        $users = User::where('role', 'student')->orderBy('full_name', 'asc')->get();

        return view('pages.admin.transactions.form', compact('books', 'users'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $book = Book::findOrFail($request->book_id);
        $now = Carbon::now();

        Transaction::create([
            ...$validated,
            'loan_date' => $now,
            'late_date' => $now->copy()->addDay(7),
            'status' => 'borrowed'
        ]);

        $book->decrement('stock');

        return redirect()->route('transactions')->with('success', 'Berhasil melakukan transaksi peminjaman.');
    }

    public function returnByAdmin(Request $request, Transaction $transaction) {
        $validated = $request->validate([
            'condition' => 'required|in:good,damaged,lost'
        ]);

        $now = Carbon::now();
        $returnDate = $now->copy()->startOfDay();
        $lateDate = $transaction->late_date->copy()->startOfDay();

        $transaction->return_date = $now;
        $transaction->condition = $validated['condition'];

        if ($validated['condition'] == 'lost') {
            $transaction->fine = 250000;
            $transaction->status = 'late';
        }
        elseif ($transaction->late_date && $returnDate->gt($lateDate)) {
            $lateDays = $lateDate->diffInDays($returnDate);
            $transaction->fine = 10000 * $lateDays;
            $transaction->status = 'late';
        }
        else {
            $transaction->fine = 0;
            $transaction->status = 'returned';
        }

        $transaction->save();

        if ($validated['condition'] != 'lost') {
            $transaction->book->increment('stock');
        }

        return redirect()->route('transactions')->with('success', 'Berhasil mengembalikan buku pinjaman.');
    }

    public function approveAdmin(Request $request, Transaction $transaction) {
        $validated = $request->validate([
            'condition' => 'required|in:good,damaged,lost'
        ]);

        $now = Carbon::now();
        $returnDate = $now->copy()->startOfDay();
        $lateDate = $transaction->late_date->copy()->startOfDay();

        $transaction->condition = $validated['condition'];

        if ($validated['condition'] == 'lost') {
            $transaction->fine = 250000;
            $transaction->status = 'late';
        }
        elseif ($transaction->late_date && $returnDate->gt($lateDate)) {
            $lateDays = $lateDate->diffInDays($returnDate);
            $transaction->fine = 20000 * $lateDays;
            $transaction->status = 'late';
        }
        else {
            $transaction->fine = 0;
            $transaction->status = 'returned';
        }

        $transaction->save();

        if ($validated['condition'] != 'lost') {
            $transaction->book->increment('stock');
        }

        return redirect()->route('transactions')->with('success', 'Persetujuan pengembalian buku telah disetujui.');
    }
    
    public function rejectAdmin(Transaction $transaction) {
        $transaction->update([
            'return_date' => null,
            'status' => 'borrowed'
        ]);

        return redirect()->route('transactions')->with('success', 'Persetujuan pengembalian buku telah ditolak.');
    }
}
