@extends('layouts.master')

@section('title', $category->name)

@section('content')
<div class="container">
    <h1>{{ $category->name }}</h1>

    <!-- Subcategory Filter -->
    @if($category->subcategories->count() > 0)
    <div class="mb-3">
        <h4>Filter by Subcategory</h4>
        <ul class="list-group list-group-horizontal">
            @foreach($category->subcategories as $subcategory)
            <li class="list-group-item">
                <a href="{{ route('subcategory', ['id' => $subcategory->id]) }}">{{ $subcategory->name }}</a>
            </li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Products List -->
    <div class="row">
        @foreach($products as $product)
        <div class="col-md-3">
            <div class="card mb-4">
                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->title }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->title }}</h5>
                    <p class="card-text">{{ $product->price }} USD</p>
                    <a href="{{ route('product.show', $product->id) }}" class="btn btn-primary">View Product</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $products->links() }}
    </div>
</div>
@endsection

