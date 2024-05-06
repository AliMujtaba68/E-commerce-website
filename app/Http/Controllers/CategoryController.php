<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // index
    public function index()
    {   
        $categories = Category::all();
        return view('admin.pages.categories.index', ['categories' => $categories]);
    }

    // store
    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required|unique:categories|max:255',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->save();

        return back()->with('success', 'Category created successfully');
    }
}
