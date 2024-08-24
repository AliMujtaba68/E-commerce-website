<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    // Home
    public function home()
    {
        // Fetch categories with subcategories
        $categories = Category::with('subcategories')->get();
        // Fetch products (if needed for the home view)
        $products = Product::with('category', 'colors')->orderBy('created_at', 'desc')->get();

        return view('pages.home', compact('products', 'categories'));
    }

    // Cart
    public function cart()
    {
        return view('pages.cart');
    }

    // Wishlist
    public function wishlist()
    {
        return view('pages.wishlist');
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

    // Show Category
    public function showCategory($id)
    {
        $category = Category::with(['products', 'subcategories'])->findOrFail($id);

        if ($category->subcategories->isEmpty()) {
            // If there are no subcategories, show the category page with products
            return view('pages.category', ['category' => $category]);
        } else {
            // If there are subcategories, show the category page with subcategories
            return view('pages.components.categories.show', ['category' => $category]);
        }
    }

    // Show Subcategory
    public function showSubcategory($id)
    {
        $subcategory = Subcategory::with('products')->findOrFail($id);
        return view('pages.components.subcategories.show', ['subcategory' => $subcategory]);
    }

    // Product
    public function product($id)
    {
        $product = Product::with('category', 'colors')->findOrFail($id);
        return view('pages.product', ['product' => $product]);
    }
}
