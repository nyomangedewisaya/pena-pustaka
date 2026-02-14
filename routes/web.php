<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookCatalogController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionUserController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Landing
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

# Admin
Route::middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::post('/categories/save/{id?}', [CategoryController::class, 'save'])->name('categories.save');
    Route::delete('/categories/{category}/delete', [CategoryController::class, 'destroy'])->name('categories.destroy');
    
    // Books
    Route::get('/books', [BookController::class, 'index'])->name('books');
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::get('/books/{book}/show', [BookController::class, 'show'])->name('books.show');
    Route::post('/books/save/{id?}', [BookController::class, 'save'])->name('books.save');
    Route::delete('/books/{book}/delete', [BookController::class, 'destroy'])->name('books.destroy');
    
    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::get('/users/{user}/show', [UserController::class, 'show'])->name('users.show');
    Route::post('/users/save/{id?}', [UserController::class, 'save'])->name('users.save');
    Route::delete('/users/{user}/delete', [UserController::class, 'destroy'])->name('users.destroy');
    
    // Transactions
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions');
    Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/transactions/store', [TransactionController::class, 'store'])->name('transactions.store');
    Route::put('/transactions/{transaction}/return', [TransactionController::class, 'returnByAdmin'])->name('transactions.return.admin');
    Route::put('/transactions/{transaction}/approve', [TransactionController::class, 'approveAdmin'])->name('transactions.approve');
    Route::put('/transactions/{transaction}/reject', [TransactionController::class, 'rejectAdmin'])->name('transactions.reject');

});

# Siswa
Route::middleware(['auth', 'role:student'])->group(function () {

    // Catalog
    Route::get('/book_catalog', [BookCatalogController::class, 'index'])->name('book.catalog');
    Route::get('/book_detail/{book}', [BookCatalogController::class, 'show'])->name('book.detail');
    Route::post('/book_borrow', [BookCatalogController::class, 'borrow'])->name('book.borrow');
    
    // Transaction User
    Route::get('/transactions/history', [TransactionUserController::class, 'index'])->name('transactions.user');
    Route::put('/transactions/{transaction}/return/user', [TransactionUserController::class, 'return'])->name('transactions.return');
    Route::post('/review/post', [TransactionUserController::class, 'review'])->name('transactions.review');

});