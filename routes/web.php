<?php

use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;

// Public Routes
Route::get('/', [PagesController::class, 'home'])->name('home');
Route::get('/cart', [PagesController::class, 'cart'])->name('cart');
Route::get('/wish-list', [PagesController::class, 'wishlist'])->name('wishlist');
Route::get('/account', [PagesController::class, 'account'])->name('account')->middleware('auth');
Route::get('/checkout', [PagesController::class, 'checkout'])->name('checkout')->middleware('auth');

// Product routes for public side (now handled by PagesController)
Route::get('/product/{id}', [PagesController::class, 'product'])->name('product.show');

// Route for category without subcategory filtering
Route::get('/category/{id}', [CategoryController::class, 'show'])->name('category');

// Route for category with subcategory filtering
Route::get('/category/{id}/subcategory/{subcategory_id}', [CategoryController::class, 'show'])->name('subcategory');

// Cart Routes
Route::post('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('addToCart');
Route::delete('/remove-from-cart/{id}', [CartController::class, 'removeFromCart'])->name('removeFromCart');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('show.login')->middleware('guest');
Route::get('/register', [AuthController::class, 'showRegister'])->name('show.register')->middleware('guest');
Route::post('/register', [AuthController::class, 'postRegister'])->name('register')->middleware('guest');
Route::post('/login', [AuthController::class, 'postLogin'])->name('login')->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Database Check Route
Route::get('/db-check', function () {
    try {
        DB::connection()->getPdo();
        return "Database connection is working properly";
    } catch (\Exception $e) {
        return "Could not connect to the database. Please check your configuration. Error: " . $e->getMessage();
    }
});

// AdminPanel Routes
Route::group(['prefix' => 'adminpanel', 'middleware' => 'admin'], function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('adminpanel');

    // Products Routes
    Route::group(['prefix' => 'products'], function () {
        Route::get('/', [ProductController::class, 'index'])->name('adminpanel.products');
        Route::get('/create', [ProductController::class, 'create'])->name('adminpanel.products.create');
        Route::post('/create', [ProductController::class, 'store'])->name('adminpanel.products.store');
        Route::get('/{id}', [ProductController::class, 'edit'])->name('adminpanel.products.edit');
        Route::put('/{id}', [ProductController::class, 'update'])->name('adminpanel.products.update');
        Route::delete('/{id}', [ProductController::class, 'destroy'])->name('adminpanel.products.destroy');
    });

    // Categories Routes
    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', [CategoryController::class, 'index'])->name('adminpanel.categories');
        Route::post('/', [CategoryController::class, 'store'])->name('adminpanel.category.store');
        Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('adminpanel.category.destroy');
    });

    // Subcategories Routes
    Route::group(['prefix' => 'subcategories'], function () {
        Route::get('/', [SubcategoryController::class, 'index'])->name('adminpanel.subcategory.index');
        Route::post('/', [SubcategoryController::class, 'store'])->name('adminpanel.subcategory.store');
        Route::delete('/{id}', [SubcategoryController::class, 'destroy'])->name('adminpanel.subcategory.destroy');
        Route::put('/{id}', [SubcategoryController::class, 'update'])->name('adminpanel.subcategory.update');
    });

    // Colors Routes
    Route::group(['prefix' => 'colors'], function () {
        Route::get('/', [ColorController::class, 'index'])->name('adminpanel.colors');
        Route::post('/', [ColorController::class, 'store'])->name('adminpanel.color.store');
        Route::delete('/{id}', [ColorController::class, 'destroy'])->name('adminpanel.color.destroy');
    });
});
