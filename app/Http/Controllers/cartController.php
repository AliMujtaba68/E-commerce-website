<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function addToCart(Request $request, $id)
    {
        // Retrieve the product and color by their IDs
        $product = Product::findOrFail($id);
        $color = Color::findOrFail($request->color);

        // Prepare the item to add to the cart
        $item = [
            'product_id' => $product->id,
            'quantity' => (int)$request->quantity, // Ensure quantity is an integer
            'color_id' => $color->id
        ];

        // Initialize the cart if it does not exist or is not an array
        if (!session()->has('cart') || !is_array(session()->get('cart'))) {
            session()->put('cart', []);
        }

        $cart = session()->get('cart');
        $key = $this->checkItemInCart($item);

        if ($key != -1) {
            // If the item exists, increment the quantity
            $cart[$key]['quantity'] += (int)$request->quantity;
        } else {
            // If the item does not exist, add it to the cart
            $cart[] = $item;
        }

        // Update the session with the new cart
        session()->put('cart', $cart);

        // Redirect back with a success message
        return back()->with('addedToCart', 'Success! Product has been added to cart');
    }

    public function checkItemInCart($item)
    {
        // Retrieve the cart session
        $cart = session()->get('cart');

        // Check if the item exists in the cart
        foreach ($cart as $key => $val) {
            // Ensure $val is an array and has the required keys
            if (is_array($val) && isset($val['product_id'], $val['color_id'])) {
                if ($val['product_id'] == $item['product_id'] && $val['color_id'] == $item['color_id']) {
                    return $key;
                }
            }
        }

        return -1;
    }

    public function removeFromCart($key)
    {
        if(session()->has('cart'))
        {
            $cart = session()->get('cart');
            array_splice($cart, $key, 1);
            session()->put('cart', $cart);
            return back()->with('removedFromCart', 'Success! Product has been removed from cart');
        }

        return back();
    }
}
