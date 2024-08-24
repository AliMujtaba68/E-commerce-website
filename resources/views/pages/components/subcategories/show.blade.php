@extends('layouts.master')

@section('title', $subcategory->name)

@section('content')
    <div class="content-area">
        <h1 class="subcategory-title">{{ $subcategory->name }}</h1>

        <div class="product-gallery">
            <ul class="list-group list-group-horizontal">
                @foreach($category->subcategories as $subcategory)
                <li class="list-group-item">
                    <a href="{{ route('subcategory', ['id' => $category->id, 'subcategory_id' => $subcategory->id]) }}">{{ $subcategory->name }}</a>
                </li>
                @endforeach
            </ul>

            {{ $products->links() }} <!-- Pagination links -->
        </div>
    </div>
@endsection
