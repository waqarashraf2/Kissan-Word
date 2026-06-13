@props(['product'])
@php
    $images = $product->images->map(fn ($image) => asset(ltrim($image->path, '/')))->values();
    $fallback = asset('logos and images/Kisaan world.jpeg');
    $primaryImage = $images->first() ?? $fallback;
    $discount = $product->discount_price && (float) $product->price > 0
        ? (int) round((1 - ((float) $product->discount_price / (float) $product->price)) * 100)
        : null;
@endphp
<article class="product-card reveal-card" data-product-card data-images='@json($images->isNotEmpty() ? $images : [$fallback])'>
    <a href="{{ route('products.show', $product) }}" class="product-media" aria-label="View {{ $product->name }}">
        <img src="{{ $primaryImage }}" alt="{{ $product->images->first()?->alt_text ?: $product->name }}" width="600" height="600" loading="lazy" decoding="async" data-product-image>
        <span class="stock-badge {{ $product->in_stock ? 'in-stock' : 'out-stock' }}">{{ $product->in_stock ? 'In Stock' : 'Out of Stock' }}</span>
        @if ($discount)<span class="discount-badge">-{{ $discount }}%</span>@endif
    </a>
    <div class="product-body">
        <a class="product-category" href="{{ route('products.index', ['category' => $product->category?->slug]) }}">{{ $product->category?->name ?? 'Agriculture' }}</a>
        <h3><a href="{{ route('products.show', $product) }}">{{ $product->name }}</a></h3>
        @if ($product->name_ur)<p class="product-name-ur" lang="ur" dir="rtl">{{ $product->name_ur }}</p>@endif
        <div class="price-row"><strong>Rs. {{ number_format((float) $product->sale_price) }}</strong>@if ($product->discount_price)<del>Rs. {{ number_format((float) $product->price) }}</del>@endif</div>
        <div class="product-actions">
            <form action="{{ route('cart.store', $product) }}" method="POST" data-ajax-cart>@csrf<input type="hidden" name="quantity" value="1">
                <button type="submit" class="add-cart" @disabled(! $product->in_stock)><span class="button-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 4h2l2 10h10l2-7H7M10 19a1 1 0 1 1-2 0 1 1 0 0 1 2 0Zm8 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z"/></svg></span><span data-button-label>Add to Cart</span></button>
            </form>
            <a href="{{ route('products.show', $product) }}" class="view-product" aria-label="View {{ $product->name }}"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h14m-5-5 5 5-5 5"/></svg></a>
        </div>
    </div>
</article>
