<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Product;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|between:1,5',
            'content' => 'required|string|max:1000',
        ]);

        $review = new Review();
        $review->product_id = $request->input('product_id');
        $review->user_id = auth()->id();
        $review->rating = $request->input('rating');
        $review->content = $request->input('content');
        $review->save();

        return redirect()->back()->with('success', 'Review submitted successfully!');
    }
}
