<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index(Request $request) {
        $query = Category::orderBy('name', 'asc');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('name', 'like', "%{$search}%");
        }

        $data = $query->get();
        $countData = $data->count();

        return view('pages.admin.categories.index', compact('data', 'countData'));
    }

    public function create() {
        return view('pages.admin.categories.form');
    }

    public function edit(Category $category) {
        return view('pages.admin.categories.form', compact('category'));
    }

    public function save(Request $request, $id = null) {
        $validated = $request->validate([
            'name' => ['required', 'string', Rule::unique('categories', 'name')->ignore($id)]
        ]);

        Category::updateOrCreate(
            ['id' => $id],
            $validated
        );

        $message = $id ? 'Kategori berhasil diupdate.' : 'Kategori berhasil ditambahkan';

        return redirect()->route('categories')->with('success', $message);
    }

    public function destroy(Category $category) {
        if ($category->books()->exists()) {
            return back()->with('error', 'Gagal dihapus! Kategori ini memiliki buku terkait.');
        }

        $category->delete();

        return redirect()->route('categories')->with('success', 'Kategori berhasil dihapus.');
    }
}
