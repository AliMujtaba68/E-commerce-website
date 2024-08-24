<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class SubcategoryController extends Controller
{
    public function index()
    {
        // Load subcategories with their parent category
        $subcategories = Subcategory::with('category')->get();
        $categories = Category::all(); // Fetch all categories

        // Pass both subcategories and categories to the view
        return view('admin.pages.subcategories.index', [
            'subcategories' => $subcategories,
            'categories' => $categories

        ]);
    }

    public function store(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Create a new subcategory and associate it with a category
        $subcategory = Subcategory::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
        ]);

        // Load the category relation
        $subcategory->load('category');

        return response()->json([
            'id' => $subcategory->id,
            'name' => $subcategory->name,
            'category_name' => $subcategory->category->name,
            'created_at' => $subcategory->created_at,
            'updated_at' => $subcategory->updated_at,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        // Validate incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Find the subcategory by ID
        $subcategory = Subcategory::find($id);

        if (!$subcategory) {
            return response()->json(['error' => 'Subcategory not found.'], 404);
        }

        // Update subcategory details
        $subcategory->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
        ]);

        // Load the category relation
        $subcategory->load('category');

        return response()->json([
            'id' => $subcategory->id,
            'name' => $subcategory->name,
            'category_name' => $subcategory->category->name,
            'created_at' => $subcategory->created_at,
            'updated_at' => $subcategory->updated_at,
        ], 200);
    }

    public function destroy($id)
    {
        try {
            $subcategory = Subcategory::findOrFail($id);
            $subcategory->delete();
            return response()->json(['message' => 'Subcategory deleted successfully.'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Subcategory not found.'], 404);
        } catch (\Exception $e) {
            // Log the error message for debugging
            Log::error('Error deleting subcategory: ' . $e->getMessage());
            return response()->json(['message' => 'Error deleting subcategory.'], 500);
        }
    }

    public function showSubcategory($id)
{
    $subcategory = Subcategory::with('products')->findOrFail($id);
    $products = $subcategory->products()->paginate(10); // Paginate products

    return view('pages.components.subcategories.show', [
        'subcategory' => $subcategory,
        'products' => $products  // Pass the $products variable to the view
    ]);
}


}
