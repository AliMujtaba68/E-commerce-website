<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category; // Don't forget to import your Category model

class CategoryController extends Controller
{
    // index
    public function index()
    {
        return view('admin.pages.categories.index');
    }

    // store

    
    public function store(Request $request)
    {   echo 'store function called';
        // validate
        $request->validate([
            'name' => 'required|unique:categories|max:255',
        ]);


        echo 'validated';
        // store 
        $category = new Category();
        $category->name = $request->name;
        $category->save();
        echo 'saved';
        // return response
        return back()->with('success');
    }


}