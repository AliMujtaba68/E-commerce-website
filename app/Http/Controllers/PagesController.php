<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    // Home
    public function home()
    {
        $products = Product::with('category', 'colors')->orderBy('created_at', 'desc')->get();
        return view('pages.home', compact('products'));
    }

    // Cart
    public function cart()
    {

        return view('pages.cart');
    }

    // Wishlist
    public function wishlist()
    {
        $products = Auth::User()->wishlist;
        return view('pages.wishlist', ['products' => $products]);
    }

    // Account
    public function account()
    {
        return view('pages.account');
    }

    // Checkout
    public function checkout()
    {
        return view('pages.checkout');
    }

    // Product
    public function product($id)
    {
        $product = Product::with('category', 'colors')->findOrfail($id);
        return view('pages.product', ['product' => $product]);
    }

    public function contact()
    {
        return view('pages.components.contact'); // Replace with your contact view
    }

    public function about()
    {
        return view('pages.components.about'); // Replace with your about view
    }

    public function privacy()
    {
        return view('pages.components.privacy'); // Replace with your privacy view
    }

    public function terms()
    {
        return view('pages.components.terms'); // Replace with your terms view
    }
}
