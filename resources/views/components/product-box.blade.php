<a href="{{ route('product.show', $product->id) }}" class="product-box">
    <div class="image">
        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->title }}" height="200px" width="200px">
    </div>
    <div class="product-title">{{ $product->title }}</div>
    <div class="color-plateletes">
        @foreach ($product->colors as $color)
            <div class="color-platelete {{ $color->code === '#ffffff' ? 'white-color' : '' }}" style="background: {{ $color->code }}"></div>
        @endforeach
    </div>
    <div class="product-category">{{ $product->category->name }}</div>
    <div class="product-price">${{ $product->price }}</div>
</a>
