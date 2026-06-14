@extends('layouts.admin')
@section('title', 'Dashboard')
@section('heading', 'Dashboard')
@section('content')
<div class="admin-page-heading"><div><h1>Store overview</h1><p>Products, content, orders and inquiries at a glance.</p></div><a class="admin-primary" href="{{ route('admin.products.create') }}">Add Product</a></div>
<div class="admin-stat-grid">
    @foreach(['products'=>'Products','orders'=>'Orders','blogs'=>'Blogs','videos'=>'Videos','magazines'=>'Magazines','inquiries'=>'New Inquiries'] as $key=>$label)
        <a href="{{ $key === 'inquiries' ? route('admin.contacts.index') : ($key === 'magazines' ? route('admin.magazines.index') : route('admin.'.($key === 'blogs' ? 'blogs' : $key).'.index')) }}" class="admin-stat"><span>{{ $label }}</span><strong>{{ number_format($counts[$key]) }}</strong></a>
    @endforeach
</div>
<section class="admin-card"><div class="admin-card-head"><div><h2>Recent orders</h2><p>Latest customer checkout activity.</p></div><a href="{{ route('admin.orders.index') }}">View all</a></div>
<div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Order</th><th>Customer</th><th>Total</th><th>Status</th><th>Date</th><th></th></tr></thead><tbody>
@forelse($recentOrders as $order)<tr><td><strong>{{ $order->order_number }}</strong></td><td>{{ $order->customer_name }}</td><td>Rs. {{ number_format((float)$order->grand_total) }}</td><td><span class="admin-status {{ $order->status }}">{{ ucfirst($order->status) }}</span></td><td>{{ $order->created_at->format('M d, Y') }}</td><td><a href="{{ route('admin.orders.show',$order) }}">Open</a></td></tr>
@empty<tr><td colspan="6" class="admin-empty">No orders received yet.</td></tr>@endforelse
</tbody></table></div></section>
@endsection
