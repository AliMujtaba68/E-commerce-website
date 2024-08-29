<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->orderBy('created_at', 'DESC')->get();
        return view('admin.pages.orders.index', compact('orders'));
    }

    public function view($id)
    {
        $states = ['Pending', 'Processing', 'Shipped', 'Completed', 'Declined'];
        $order = Order::with('user', 'items', 'items.product', 'items.color')->findOrFail($id);
        return view('admin.pages.orders.view', compact('order', 'states'));
    }

    public function updateStatus($id, Request $request)
{
    // Validate the incoming request data
    $request->validate([
        'status' => 'required|in:Pending,Processing,Shipped,Completed,Declined'
    ]);

    // Find the order and update its status
    $order = Order::findOrFail($id);
    $order->update([
        'status' => $request->input('status')
    ]);

    return response()->json(['success' => true, 'message' => 'Order status updated successfully.']);
}


}
