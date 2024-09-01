<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // adminpanel
    public function index()
    {
        $products = Product::with('category')->orderBy('created_at', 'desc')->get();
        return view('admin.pages.products.index', ['products' => $products]);
    }

    // create
    public function create()
    {
        $categories = Category::all();
        $colors = Color::all();
        return view('admin.pages.products.create', ['categories' => $categories, 'colors' => $colors]);
    }

    // store
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|max:255',
                'description' => 'required',
                'price' => 'required|numeric',
                'category_id' => 'required|exists:categories,id',
                'colors' => 'required|array',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);

            $image_name = 'products/' . time() . rand(0, 9999) . '.' . $request->image->getClientOriginalExtension();
            $request->image->storeAs('public', $image_name);

            $product = Product::create([
                'title' => $request->title,
                'description' => $request->description,
                'price' => $request->price * 100,
                'category_id' => $request->category_id,
                'image' => $image_name
            ]);

            $product->colors()->attach($request->colors);

            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => $e->validator->errors()->first()]);
        } catch (\Exception $e) {
            Log::error('Product creation error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred while creating the product.']);
        }
    }

    // edit
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $colors = Color::all();
        return view('admin.pages.products.edit', ['categories' => $categories, 'colors' => $colors, 'product' => $product]);
    }

    // update
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'required|max:255',
                'description' => 'required',
                'price' => 'required|numeric',
                'category_id' => 'required|exists:categories,id',
                'colors' => 'required|array',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);

            $product = Product::findOrFail($id);
            $image_name = $product->image;

            if ($request->image) {
                $image_name = 'products/' . time() . rand(0, 9999) . '.' . $request->image->getClientOriginalExtension();
                $request->image->storeAs('public', $image_name);
            }

            $product->update([
                'title' => $request->title,
                'description' => $request->description,
                'price' => $request->price * 100,
                'category_id' => $request->category_id,
                'image' => $image_name
            ]);

            $product->colors()->sync($request->colors);

            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => $e->validator->errors()->first()]);
        } catch (\Exception $e) {
            Log::error('Product update error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred while updating the product.']);
        }
    }

    // delete
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);

            // Check if the category is null, if so, reassign to "Uncategorized"
            if ($product->category === null) {
                $uncategorizedCategory = Category::firstOrCreate(['name' => 'Uncategorized']);
                $product->category_id = $uncategorizedCategory->id;
                $product->save();
            }

            $product->delete();
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            Log::error('Product deletion error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete product'], 500);
        }
    }

    public function getCategories()
{
    $categories = Category::all();
    return response()->json($categories);
}


}
