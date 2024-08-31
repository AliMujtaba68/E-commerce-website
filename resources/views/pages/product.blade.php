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
                    <p class="p-category">-{{ optional($product->category)->name ?? 'Uncategorized' }}</p>
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

                    <!-- Centered Review Form -->
                    <div class="review-section">
                        <h3>Submit a Review</h3>
                        <form action="{{ route('reviews.store', ['product' => $product->id]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="form-group">
                                <label for="rating">Rating</label>
                                <select name="rating" id="rating" class="form-control" required>
                                    <option value="">-- Select Rating --</option>
                                    @for($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="content">Review</label>
                                <textarea name="content" id="content" class="form-control" rows="4" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Review</button>
                        </form>
                    </div>

                    <!-- Display Reviews -->
                    <div class="reviews">
                        <h3>Customer Reviews</h3>
                        @forelse ($product->reviews as $review)
                            <div class="review">
                                <div class="review-header">
                                    <p class="review-user">{{ $review->user->name }}</p>
                                    <p class="review-rating">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="star">{{ $i <= $review->rating ? '★' : '☆' }}</span>
                                        @endfor
                                    </p>
                                </div>
                                <p class="review-content">{{ $review->content }}</p>
                            </div>
                        @empty
                            <p>No reviews yet.</p>
                        @endforelse
                    </div>
                </section>
            </div>
        </div>
    </div>

@endsection
