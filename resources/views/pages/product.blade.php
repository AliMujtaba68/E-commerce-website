@extends('layouts.master')
@section('title', $product->title)
@section('content')
    <div class="product-page">
        <div class="container">
            <div class="product-page-row">
                <section class="product-page-image">
                    <img src="{{asset('storage/' . $product->image)}}" alt="{{$product->title}}">
                </section>
                <section class="product-page-details">
                    <p class="p-title">{{$product->title}}</p>
                    <p class="p-price">${{$product->price/100}}</p>
                    <p class="p-category">-{{$product->category->name}}</p>
                    <p class="p-description">{{$product->description}}</p>
                </section>
            </div>
        </div>
    </div>
@endsection
