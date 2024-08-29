<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    public function createCheckoutSession(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'required|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'zip' => 'nullable|string|max:10', // Added zip code validation
            'country' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Get the authenticated user
        $user = Auth::user();

        // Retrieve cart items from session
        $cartItems = session()->get('cart', []);
        Log::info('Cart Items:', ['cartItems' => $cartItems]);

        if (empty($cartItems)) {
            return response()->json(['message' => 'Your cart is empty'], 400);
        }

        // Calculate the total amount using the Cart model method
        $totalAmount = Cart::totalAmount($cartItems);
        Log::info('Total Amount:', ['total' => $totalAmount]);

        // Ensure the total amount is formatted correctly as a numeric value
        $totalAmount = str_replace(['$', ','], '', $totalAmount);

        // Create the order
        $order = Order::create([
            'user_id' => $user ? $user->id : null,
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'zip' => $request->input('zip'), // Save zip code
            'country' => $request->input('country'),
            'total' => $totalAmount, // Save the numeric total amount
            'status' => 'pending',
        ]);

        // Save items to the order
        foreach ($cartItems as $item) {
            Item::create([
                'product_id' => $item['product_id'],
                'color_id' => $item['color_id'] ?? null, // Optional color_id
                'order_id' => $order->id,
                'quantity' => $item['quantity'],
            ]);
        }

        // Clear the cart
        session()->forget('cart');

        // Return a success message
        return view('pages.orderSuccess', ['order' => $order]);
    }
}
