<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request) {
        $query = User::where('role', 'student')->latest();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $data = $query->get();
        $countData = $data->count();

        return view('pages.admin.users.index', compact('data', 'countData'));
    }

    public function create() {
        return view('pages.admin.users.form');
    }

    public function edit(User $user) {
        return view('pages.admin.users.form', compact('user'));
    }

    public function save(Request $request, $id = null) {
        $validated = $request->validate([
            'full_name' => 'required|string|max:100',
            'username' => ['required', 'string', 'min:8', 'alpha_dash', Rule::unique('users', 'username')->ignore($id)],
            'password' => $id ? 'nullable|string|min:8' : 'required|string|min:8',
            'nisn' => ['required', 'string', Rule::unique('users', 'nisn')->ignore($id)],
            'class' => 'required|string',
            'phone' => 'required|string|max:13',
            'address' => 'required|string',
        ]);
        $validated['role'] = 'student';

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        }
        else {
            unset($validated['password']);
        }

        User::updateOrCreate(
            ['id' => $id],
            $validated
        );

        $message = $id ? 'Anggota berhasil diupdate.' : 'Anggota berhasil ditambahkan.';

        return redirect()->route('users')->with('success', $message);
    }
    
    public function destroy(User $user) {
        if ($user->transactions()->exists()) {
            return back()->with('error', 'Gagal dihapus! Anggota ini memiliki transaksi peminjaman.');
        }
        
        $user->delete();

        return redirect()->route('users')->with('success', 'Anggota berhasil dihapus.');
    }

    public function show($id) {
        $user = User::findOrFail($id);

        return view('pages.admin.users.show', compact('user'));
    }
}
