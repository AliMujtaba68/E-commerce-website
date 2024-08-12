@extends('layouts.master')
@section('title', $product->title)
@section('content')

    @if (session()->has('addedToCart'))
        <section class="pop-up">
            <div class="pop-up-box">
                <div class="pop-up-title">
                    {{ session()->get('addedToCart') }}
                </div>
                <div class="pop-up-actions">
                    <a href="{{ route('home') }}" class="btn btn-outline">Continue Shopping</a>
                    <a href="{{ route('cart') }}" class="btn btn-primary">Go to Cart</a>
                </div>
            </div>
        </section>
    @endif

    <div class="product-page">
        <div class="container">
            <div class="product-page-row">
                <section class="product-page-image">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}">
                </section>
                <section class="product-page-details">
                    <p class="p-title">{{ $product->title }}</p>
                    <p class="p-price">${{ $product->price / 100 }}</p>
                    <p class="p-category">-{{ $product->category->name }}</p>
                    <p class="p-description">{{ $product->description }}</p>
                    <form action="{{ route('addToCart', $product->id) }}" method="post">
                        @csrf
                        <div class="p-form">
                            <div class="p-colors">
                                <label for="color">Colors</label>
                                <select name="color" id="color" required>
                                    <option value="">-- color --</option>
                                    @foreach ($product->colors as $color)
                                        <option value="{{ $color->id }}">{{ $color->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="p-quantity">
                                <label for="quantity">Quantity</label>
                                <input type="number" name="quantity" min="1" max="100" value="1" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-cart">Add to Cart</button>
                    </form>
                </section>
            </div>
        </div>
    </div>

@endsection
