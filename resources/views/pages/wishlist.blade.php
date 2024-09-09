@extends('layouts.master')
@section('title', 'Wishlist')
@section('content')

    <header class="page-header">
        <h1>Your Wishlist</h1>
    </header>
    <div class="container" style="margin-top: 70px">
        <div class="wishlist-items">
            <div class="wishlist-product">
                @foreach ($products as $product)
                    <x-product-box :product="$product" />
                @endforeach
            </div>
        </div>
    </div>

@endsection
