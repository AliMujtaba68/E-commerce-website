<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::all();
        return view('admin.pages.colors.index', ['colors' => $colors]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:colors|max:255',
            'code' => 'required|max:255'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
    
        $color = Color::create([
            'name' => $request->name,
            'code' => $request->code,
        ]);
    
        session()->flash('success', 'Color added successfully.');
    
        return response()->json($color, 201);
    }
    
    public function destroy($id)
    {
        $color = Color::findOrFail($id);
    
        try {
            $color->delete();
            session()->flash('success', 'Color deleted successfully.');
            return response()->json(['message' => 'Color deleted successfully.'], 200);
        } catch (\Exception $e) {
            session()->flash('error', 'Error deleting color.');
            return response()->json(['message' => 'Error deleting color.'], 500);
        }
    }
}
