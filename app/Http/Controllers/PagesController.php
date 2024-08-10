<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    // Home
    public function home()
{
    $products = Product::with('category', 'colors')->orderBy('created_at', 'desc')->get();
    return view('pages.home', compact('products'));
}



    // cart
    public function cart()
    {
        return view('pages.cart');
    }

    // wishlist
    public function wishlist()
    {
        return view('pages.wishlist');
    }

    // account

    public function account()
    {
        return view('pages.account');
    }

    // product
    public function product($id)
    {
        $product = Product::with('category', 'colors')->findOrfail($id);
        return view('pages.product', ['product' => $product]);
    }
}
