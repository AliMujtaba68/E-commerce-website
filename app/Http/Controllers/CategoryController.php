<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function index()
    {
        // Load categories with the count of products and subcategories
        $categories = Category::withCount(['products', 'subcategories'])->get();
        return view('admin.pages.categories.index', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $category = Category::create([
            'name' => $request->name,
        ]);

        session()->flash('success', 'Category added successfully.');

        return response()->json($category, 201);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        try {
            // Move products to the "Uncategorized" category before deletion
            $uncategorizedCategory = Category::firstOrCreate(['name' => 'Uncategorized']);

            Product::where('category_id', $category->id)
                ->update(['category_id' => $uncategorizedCategory->id]);

            $category->delete();

            session()->flash('success', 'Category deleted successfully, and products moved to Uncategorized.');
            return response()->json(['message' => 'Category deleted successfully.'], 200);
        } catch (\Exception $e) {
            session()->flash('error', 'Error deleting category.');
            return response()->json(['message' => 'Error deleting category.'], 500);
        }
    }
}
