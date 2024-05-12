<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    //adminpanel

    public function index()
    {
        return view('admin.pages.products.index');
    }

    // create
    public function create()
    {
        return "Create Product";
    }

    // store

    public function store(Request $request)
    {
        return "save products";
    }

    // edit

    public function edit()
    {
        return "Edit Product";
    }

    // update

    public function update(Request $request)
    {
        return "Update Product";
    }

    // delete

    public function destroy($id)
    {
        return "Delete Product";
    }
}
