<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CarouselController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\DashboardController;

// Public Routes
Route::get('/', [PagesController::class, 'home'])->name('home');
Route::get('/cart', [PagesController::class, 'cart'])->name('cart');
Route::get('/wish-list', [PagesController::class, 'wishlist'])->name('wishlist');
Route::get('/account', [PagesController::class, 'account'])->name('account')->middleware('auth');
Route::get('/checkout', [PagesController::class, 'checkout'])->name('checkout')->middleware('auth');
Route::get('/products/{id}', [PagesController::class, 'product'])->name('product');
Route::get('/contact', [PagesController::class, 'contact'])->name('contact.page');
Route::get('/about', [PagesController::class, 'about'])->name('about.page');
Route::get('/privacy', [PagesController::class, 'privacy'])->name('privacy.page');
Route::get('/terms', [PagesController::class, 'terms'])->name('terms.page');

// Checkout Route
Route::post('/create-checkout-session', [CheckoutController::class, 'createCheckoutSession'])->name('createCheckoutSession')->middleware('auth');

// Payment Success and Cancel Routes
Route::get('/payment/success', [PagesController::class, 'paymentSuccess'])->name('payment.success');
Route::get('/payment/cancel', [PagesController::class, 'paymentCancel'])->name('payment.cancel');

// Cart Routes
Route::post('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('addToCart');
Route::delete('/remove-from-cart/{id}', [CartController::class, 'removeFromCart'])->name('removeFromCart');

// Wishlist Routes
Route::post('/add-to-wishlist/{id}', [WishlistController::class, 'post'])->name('addToWishlist')->middleware('auth');
Route::post('/remove-from-wishlist/{id}', [WishlistController::class, 'remove'])->name('removeFromWishlist')->middleware('auth');

// Authentication Routes
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

// Admin Panel Routes
Route::prefix('adminpanel')->middleware('admin')->group(function() {
    Route::get('/', [AdminController::class, 'dashboard'])->name('adminpanel.dashboard');

    // Dashboard Data Route
    Route::get('/dashboard/data', [DashboardController::class, 'getData'])->name('adminpanel.dashboard.data');

    // Products
    Route::prefix('products')->group(function ()  {
        Route::get('/', [ProductController::class, 'index'])->name('adminpanel.products');
        Route::get('/create', [ProductController::class, 'create'])->name('adminpanel.products.create');
        Route::post('/create', [ProductController::class, 'store'])->name('adminpanel.products.store');
        Route::get('/{id}', [ProductController::class, 'edit'])->name('adminpanel.products.edit');
        Route::put('/{id}', [ProductController::class, 'update'])->name('adminpanel.products.update');
        Route::delete('/{id}', [ProductController::class, 'destroy'])->name('adminpanel.products.destroy');
        Route::get('/product/{id}/reviews', [ProductController::class, 'review_user'])->name('product.reviews');

    });

    // Categories
    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('adminpanel.categories');
        Route::post('/', [CategoryController::class, 'store'])->name('adminpanel.category.store');
        Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('adminpanel.category.destroy');
    });

    // Colors
    Route::prefix('colors')->group(function () {
        Route::get('/', [ColorController::class, 'index'])->name('adminpanel.colors');
        Route::post('/', [ColorController::class, 'store'])->name('adminpanel.color.store');
        Route::delete('/{id}', [ColorController::class, 'destroy'])->name('adminpanel.color.destroy');
    });

    // Orders
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('adminpanel.orders');
        Route::get('/{id}', [OrderController::class, 'view'])->name('adminpanel.orders.view');
        Route::post('/{id}', [OrderController::class, 'updateStatus'])->name('adminpanel.orders.status.update');
    });

    // Reviews
    Route::post('/product/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});
