@extends('layouts.app')
@section('title', 'Order Confirmed | KISANWORLD')
@section('content')
<section class="success-page"><div><span>✓</span><p class="section-kicker">Order received</p><h1>Thank you for your order.</h1><p>Your order number is <strong>{{ $orderNumber }}</strong>. Our team will contact you to confirm delivery.</p><a href="{{ route('products.index') }}" class="button button-primary">Continue shopping</a></div></section>
@endsection
