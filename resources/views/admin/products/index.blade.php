@extends('layouts.admin')
@section('title', 'Products')
@section('heading', 'Products')
@section('content')
<div class="admin-page-heading"><div><h1>Products</h1><p>Manage prices, stock, descriptions, SEO and image galleries.</p></div><a class="admin-primary" href="{{ route('admin.products.create') }}">Add Product</a></div>
<section class="admin-card"><div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Product</th><th>Category</th><th>Price</th><th>Stock</th><th>Status</th><th>Updated</th><th></th></tr></thead><tbody>
@forelse($products as $product)<tr><td><strong>{{ $product->name }}</strong><small>{{ $product->sku }}</small></td><td>{{ $product->category?->name }}</td><td>Rs. {{ number_format((float)$product->sale_price) }}</td><td>{{ $product->manage_stock ? $product->stock_quantity : 'Unlimited' }}</td><td><span class="admin-status {{ $product->is_active ? 'completed' : 'cancelled' }}">{{ $product->is_active ? 'Active' : 'Hidden' }}</span></td><td>{{ $product->updated_at->format('M d, Y') }}</td><td class="admin-actions"><a href="{{ route('products.show',$product) }}" target="_blank">View</a><a href="{{ route('admin.products.edit',$product) }}">Edit</a><x-admin.delete-form :action="route('admin.products.destroy',$product)" /></td></tr>
@empty<tr><td colspan="7" class="admin-empty">No products found.</td></tr>@endforelse
</tbody></table></div><div class="admin-pagination">{{ $products->links() }}</div></section>
@endsection
