@extends('layouts.master')
@section('title', 'Cart')
@section('content')
    <header class="page-header">
        <h1>Cart</h1>
        <h3 class="cart-amount">Grand Total: {{ \App\Models\Cart::totalAmount(session()->get('cart', [])) }}</h3>
    </header>

    @if (session()->has('removedFromCart'))
    <section class="pop-up">
        <div class="pop-up-box">
            <div class="pop-up-title">
                {{ session()->get('removedFromCart') }}
            </div>
            <div class="pop-up-actions">
                <a href="{{ route('home') }}" class="btn btn-outline">Continue Shopping</a>
                <a href="{{ route('cart') }}" class="btn btn-primary">Go to Cart</a>
            </div>
        </div>
    </section>
    @endif

    <main class="cart-page">
        <div class="container">
            <div class="cart-table">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Color</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $cartItems = session()->get('cart', []);
                        @endphp

                        @if(count($cartItems) > 0)
                            @foreach ($cartItems as $key => $item)
                                @php
                                    $product = \App\Models\Product::find($item['product_id']);
                                    $color = \App\Models\Color::find($item['color_id']);
                                @endphp
                                <tr>
                                    <td>
                                        <a href="{{ route('product', $product->id) }}" class="cart-item-title">
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="">
                                            <p>{{ $product->title }}</p>
                                        </a>
                                    </td>
                                    <td>{{ $color->name }}</td>
                                    <td>${{ \App\Models\Cart::centsToPrice($product->price) }}</td>
                                    <td>{{ $item['quantity'] }}</td>
                                    <td>${{ \App\Models\Cart::itemTotal($item) }}</td>
                                    <td>
                                        <form action="{{ route('removeFromCart', $key) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-primary">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            <tr class="cart-total">
                                <td colspan="4" style="text-align: right">Total</td>
                                <td>${{ \App\Models\Cart::totalAmount($cartItems) }}</td>
                            </tr>
                        @else
                        <tr>
                            <td colspan="6" class="empty-cart">No items in the cart</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="cart-actions">
                <a href="{{ route('home') }}" class="btn btn-primary">Continue Shopping</a>
                <a href="{{route('checkout')}}" class="btn btn-primary">Checkout</a>
            </div>
        </div>
    </main>
@endsection
