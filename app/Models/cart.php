<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;

class Cart
{
    // Convert cents to formatted price
    public static function centsToPrice($cents)
    {
        return number_format($cents / 100, 2);
    }

    // Calculate the unit price with quantity
    public static function unitPrice($item)
    {
        if (!isset($item['product_id']) || !isset($item['quantity'])) {
            return '$0.00 x 0';
        }

        $product = \App\Models\Product::find($item['product_id']);
        if (!$product) {
            return '$0.00 x 0';
        }

        $price = $product->price;
        $quantity = $item['quantity'];
        return '$' . self::centsToPrice($price) . ' x ' . $quantity;
    }

    // Calculate total price for the item
    public static function itemTotal($item)
    {
        if (!isset($item['product_id']) || !isset($item['quantity'])) {
            return '$0.00';
        }

        $product = \App\Models\Product::find($item['product_id']);
        if (!$product) {
            return '$0.00';
        }

        $price = $product->price;
        $quantity = $item['quantity'];
        return '$' . self::centsToPrice($price * $quantity);
    }

    // Calculate total cart amount
    public static function totalAmount($cartItems)
    {
        $total = 0;
        foreach ($cartItems as $item) {
            if (isset($item['product_id']) && isset($item['quantity'])) {
                $product = \App\Models\Product::find($item['product_id']);
                if ($product) {
                    $price = $product->price;
                    $total += $price * $item['quantity'];
                    // Debugging output
                    Log::info("Product ID: {$item['product_id']}, Price: $price, Quantity: {$item['quantity']}, Item Total: " . ($price * $item['quantity']));
                } else {
                    Log::warning("Product with ID {$item['product_id']} not found.");
                }
            } else {
                Log::warning("Item missing 'product_id' or 'quantity': " . json_encode($item));
            }
        }
        $formattedTotal = self::centsToPrice($total);
        Log::info("Total Cart Amount: $formattedTotal");
        return '$' . $formattedTotal;
    }
}
