@extends('layouts.app')
@section('title', 'Checkout | KISANWORLD')
@section('content')
<x-page-hero eyebrow="Secure checkout" title="Place your order" text="Enter delivery details and confirm your selected products." />
<section class="inner-section section-shell checkout-layout">
    @if($products->isEmpty())<div class="empty-state"><strong>Your cart is empty.</strong><a href="{{ route('products.index') }}">Shop products →</a></div>
    @else
    <form action="{{ route('checkout.store') }}" method="POST" class="site-form checkout-form">@csrf
        <div class="form-grid"><label>Name<input name="customer_name" value="{{ old('customer_name', auth()->user()?->name) }}" required></label><label>Phone<input name="customer_phone" value="{{ old('customer_phone', auth()->user()?->phone) }}" required></label></div>
        <label>Email<input type="email" name="customer_email" value="{{ old('customer_email', auth()->user()?->email) }}"></label>
        <label>Address<textarea name="shipping_address" rows="4" required>{{ old('shipping_address') }}</textarea></label>
        <div class="form-grid"><label>City<input name="city" value="{{ old('city') }}"></label><label>Payment<select name="payment_method"><option value="cash_on_delivery">Cash on delivery</option><option value="bank_transfer">Bank transfer</option></select></label></div>
        <label>Order notes<textarea name="notes" rows="3">{{ old('notes') }}</textarea></label>
        @foreach($products as $index => $product)<input type="hidden" name="items[{{ $index }}][product_id]" value="{{ $product->id }}"><input type="hidden" name="items[{{ $index }}][quantity]" value="{{ $cart[$product->id] }}">@endforeach
        <button class="button button-primary">Place order</button>
    </form>
    <aside class="cart-summary"><h2>Order summary</h2>@foreach($products as $product)<div><span>{{ $product->name }} × {{ $cart[$product->id] }}</span><strong>Rs. {{ number_format((float)$product->sale_price * $cart[$product->id]) }}</strong></div>@endforeach<hr><div><span>Total</span><strong>Rs. {{ number_format($products->sum(fn($product)=>(float)$product->sale_price * $cart[$product->id])) }}</strong></div></aside>
    @endif
</section>
@endsection
