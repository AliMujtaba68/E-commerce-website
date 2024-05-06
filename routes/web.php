<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

Route::get('/', [PagesController::class, 'home'])->name('home');
Route::get('cart', [PagesController::class, 'cart'])->name('cart');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');

Route::post('/register', [AuthController::class, 'postRegister'])->name('register')->middleware('guest');
Route::post('/login', [AuthController::class, 'postLogin'])->name('login')->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


// AdminPanel Routes

Route::group(['prefix' => 'adminpanel', 'middleware' => 'admin'], function() {

    Route::get('/', [AdminController::class, 'dashboard'])->name('adminpanel');

    // Products
    Route::group(['prefix' => 'products'], function() {
        Route::get('/', [ProductController::class, 'index'])->name('adminpanel.products');
        Route::get('create', [ProductController::class, 'create'])->name('adminpanel.products.create');
        Route::post('store', [ProductController::class, 'store'])->name('adminpanel.products.store');
        Route::get('{id}', [ProductController::class, 'show'])->name('adminpanel.products.show');
        Route::get('{id}/edit', [ProductController::class, 'edit'])->name('adminpanel.products.edit');
        Route::put('{id}/update', [ProductController::class, 'update'])->name('adminpanel.products.update');
        Route::delete('{id}/delete', [ProductController::class, 'destroy'])->name('adminpanel.products.delete');
        Route::get('{id}/restore', [ProductController::class, 'restore'])->name('adminpanel.products.restore');
    });

      // categories
        Route::group(['prefix' => 'categories'], function() {
        Route::get('/', [CategoryController::class, 'index'])->name('adminpanel.categories');
        Route::post('/create', [CategoryController::class, 'store'])->name('adminpanel.categories.store');
    });
});