<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    // adminpanel
    public function index()
    {
        return view('layouts.admin.pages.products.index');
    }

    // adminpanel/create

    public function create()
    {
        return view('layouts.admin.pages.products.create');
    }

    // adminpanel/store

    public function store(Request $request)
    {
        return 'Store Product';
    }

    // adminpanel/{id}

    public function show($id)
    {
        return 'Show Product ' . $id;
    }

     // adminpanel/edit

    public function edit($id)
    {
        return view('layouts.admin.pages.products.edit');
    }

    // adminpanel/update

    public function update(Request $request, $id)
    {
        return 'Update Product ' . $id;
    }

    // adminpanel/delete

    public function destroy($id)
    {
        return 'Delete Product ' . $id;
    }

    // adminpanel/{id}/restore

    public function restore($id)
    {
        return 'Restore Product ' . $id;
    }

    // adminpanel/{id}/force-delete

    public function forceDelete($id)
    {
        return 'Force Delete Product ' . $id;
    }

    // adminpanel/trash

    public function trash()
    {
        return 'Trash Products';
    }



}
