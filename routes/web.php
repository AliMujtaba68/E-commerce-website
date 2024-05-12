<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

Route::get('/', [PagesController::class, 'home'])->name('home');
Route::get('cart', [PagesController::class, 'cart'])->name('cart');

// Auth Routes

Route::get('/login', [AuthController::class, 'showLogin'])->name('show.login')->middleware('guest');
Route::get('/register', [AuthController::class, 'showRegister'])->name('show.register')->middleware('guest');

Route::post('/register', [AuthController::class, 'postRegister'])->name('register')->middleware('guest');
Route::post('/login', [AuthController::class, 'postLogin'])->name('login')->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Database check route
Route::get('/db-check', function () {
    try {
        DB::connection()->getPdo();
        return "Database connection is working properly";
    } catch (\Exception $e) {
        return "Could not connect to the database.  Please check your configuration. error:" . $e ;
    }
});

// AdminPanel Routes
Route::group(['prefix' => 'adminpanel', 'middleware' => 'admin'], function() {

    Route::get('/', [AdminController::class, 'dashboard'])->name('adminpanel');


    // Products
    Route::group(['prefix' => 'products'], function ()  {
        Route::get('/', [ProductController::class, 'index'])->name('adminpanel.products');
        Route::get('/create', [ProductController::class, 'create'])->name('adminpanel.create');
        Route::post('/create', [ProductController::class, 'store'])->name('adminpanel.store');
    });

    // Categories
    Route::group(['prefix' => 'categories'], function ()  {
        Route::get('/', [CategoryController::class, 'index'])->name('adminpanel.categories');
        Route::post('/', [CategoryController::class, 'store'])->name('adminpanel.category.store');
    });

}); 