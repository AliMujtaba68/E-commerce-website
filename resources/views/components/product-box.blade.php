<section class="product-box">
    <div class="image">
        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->title }}" height="200px" width="200px">
    @auth
        @if(auth()->user()->wishlist->contains($product))
            <form action="{{ route('removeFromWishlist', $product->id) }}" method="post">
                @csrf
                <button class="add-to-wishlist" type="submit">Remove from Wishlist</button>
            </form>
        @else
            <form action="{{ route('addToWishlist', $product->id) }}" method="post">
                @csrf
                <button class="add-to-wishlist" type="submit">Add to Wishlist</button>
            </form>
        @endif
    @endauth
    </div>
    <a href="{{ route('product', $product->id) }}">
    <div class="product-title">{{ $product->title }}</div>
    <div class="color-plateletes">
        @foreach ($product->colors as $color)
            <div class="color-platelete {{ $color->code === '#ffffff' ? 'white-color' : '' }}" style="background: {{ $color->code }}"></div>
        @endforeach
    </div>
    <div class="product-category">{{ optional($product->category)->name ?? 'Uncategorized' }}</div>
    <div class="product-price">${{ $product->price / 100 }}</div>
    </a>
</section>
