@extends('layouts.admin')
@section('title', 'Orders')
@section('heading', 'Orders')
@section('content')
<div class="admin-page-heading"><div><h1>Orders</h1><p>Review customer orders, payments and fulfilment status.</p></div></div>
<section class="admin-card"><div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Order</th><th>Customer</th><th>Phone</th><th>Total</th><th>Payment</th><th>Status</th><th>Date</th><th></th></tr></thead><tbody>@forelse($orders as $order)<tr><td><strong>{{ $order->order_number }}</strong></td><td>{{ $order->customer_name }}</td><td>{{ $order->customer_phone }}</td><td>Rs. {{ number_format((float)$order->grand_total) }}</td><td><span class="admin-status {{ $order->payment_status }}">{{ ucfirst($order->payment_status) }}</span></td><td><span class="admin-status {{ $order->status }}">{{ ucfirst($order->status) }}</span></td><td>{{ $order->created_at->format('M d, Y') }}</td><td><a href="{{ route('admin.orders.show',$order) }}">Open</a></td></tr>@empty<tr><td colspan="8" class="admin-empty">No orders found.</td></tr>@endforelse</tbody></table></div><div class="admin-pagination">{{ $orders->links() }}</div></section>
@endsection
