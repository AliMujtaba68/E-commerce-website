<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'subcategory', 'colors')->get();
        return view('admin.pages.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $subcategories = Subcategory::all(); // Fetch all subcategories
        $colors = Color::all();

        return view('admin.pages.products.create', compact('categories', 'subcategories', 'colors'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|max:255',
                'description' => 'required',
                'price' => 'required|numeric',
                'category_id' => 'required|exists:categories,id',
                'subcategory_id' => 'nullable|exists:subcategories,id',
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
                'subcategory_id' => $request->subcategory_id,
                'image' => $image_name
            ]);

            $product->colors()->attach($request->colors);

            return response()->json(['success' => true]);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'message' => $e->validator->errors()->first()]);
        } catch (\Exception $e) {
            Log::error('Product creation error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred while creating the product.']);
        }
    }

    public function edit($id)
    {
        $product = Product::with('colors')->findOrFail($id);
        $categories = Category::all();
        $subcategories = Subcategory::where('category_id', $product->category_id)->get();
        $colors = Color::all();
        return view('admin.pages.products.edit', compact('product', 'categories', 'subcategories', 'colors'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'required|max:255',
                'description' => 'required',
                'price' => 'required|numeric',
                'category_id' => 'required|exists:categories,id',
                'subcategory_id' => 'nullable|exists:subcategories,id',
                'colors' => 'required|array',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);

            $product = Product::findOrFail($id);

            $product->title = $request->title;
            $product->description = $request->description;
            $product->price = $request->price * 100;
            $product->category_id = $request->category_id;
            $product->subcategory_id = $request->subcategory_id;

            if ($request->hasFile('image')) {
                $image_name = 'products/' . time() . rand(0, 9999) . '.' . $request->image->getClientOriginalExtension();
                $request->image->storeAs('public', $image_name);
                $product->image = $image_name;
            }

            $product->save();

            $product->colors()->sync($request->colors);

            return response()->json(['success' => true]);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'message' => $e->validator->errors()->first()]);
        } catch (\Exception $e) {
            Log::error('Product update error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred while updating the product.']);
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Product deletion error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred while deleting the product.']);
        }
    }
}
