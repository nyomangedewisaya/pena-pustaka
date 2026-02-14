<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    public function index(Request $request) {
        $query = Book::with('category')->withAvg('reviews', 'rating')->latest();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            }); 
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $data = $query->get();
        $countData = $data->count();
        $categories = Category::orderBy('name', 'asc')->get();
        
        return view('pages.admin.books.index', compact('data', 'countData', 'categories'));
    }
    
    public function create() {
        $categories = Category::orderBy('name', 'asc')->get();
        return view('pages.admin.books.form', compact('categories'));
    }

    public function edit(Book $book) {
        $categories = Category::orderBy('name', 'asc')->get();
        return view('pages.admin.books.form', compact('categories', 'book'));
    }

    public function save(Request $request, $id = null) {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => ['required', 'string', 'max:100', Rule::unique('books', 'title')->ignore($id)],
            'cover' => $id ? 'nullable|image|mimes:png,jpg,jpeg|max:2048' : 'required|image|mimes:png,jpg,jpeg|max:2048',
            'author' => 'required|string|max:100',
            'publisher' => 'required|string|max:100',
            'publication_year' => 'required|integer|min:1900|max:' . date('Y'),
            'stock' => 'required|integer',
            'synopsis' => 'required|string'
        ]);

        $book = $id ? Book::findOrFail($id) : null;

        if ($request->hasFile('cover')) {
            if ($book && $book->cover) {
                Storage::disk('public')->delete($book->cover);
            }
            $validated['cover'] = $request->file('cover')->store('images', 'public');
        }

        Book::updateOrCreate(
            ['id' => $id],
            $validated
        );

        $message = $id ? 'Buku berhasil diupdate.' : 'Buku berhasil ditambahkan';

        return redirect()->route('books')->with('success', $message);
    }

    public function destroy(Book $book) {
        if ($book->transactions()->exists()) {
            return back()->with('error', 'Gagal dihapus! Buku ini memiliki transaksi aktif.');
        }

        if ($book->cover) {
            Storage::disk('public')->delete($book->cover);
        }

        $book->reviews()->delete();
        $book->transactions()->delete();
        $book->delete();

        return redirect()->route('books')->with('success', 'Buku berhasil dihapus.');
    }

    public function show($id) {
        $book = Book::with(['category', 'reviews.user'])->findOrFail($id);
        $avgRating = $book->reviews()->avg('rating');

        return view('pages.admin.books.show', compact('book', 'avgRating'));
    }
}
