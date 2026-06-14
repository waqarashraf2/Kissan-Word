@extends('layouts.admin')
@section('title', 'Product Categories')
@section('heading', 'Product Categories')
@section('content')
<div class="admin-page-heading"><div><h1>Product categories</h1><p>Organize products into categories and subcategories.</p></div><a class="admin-primary" href="{{ route('admin.categories.create') }}">Add Category</a></div>
<section class="admin-card"><div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Name</th><th>Parent</th><th>Order</th><th>Status</th><th></th></tr></thead><tbody>@forelse($categories as $category)<tr><td><strong>{{ $category->name }}</strong><small>{{ $category->name_ur }}</small></td><td>{{ $category->parent?->name ?? 'Top level' }}</td><td>{{ $category->sort_order }}</td><td><span class="admin-status {{ $category->is_active ? 'completed' : 'cancelled' }}">{{ $category->is_active ? 'Active' : 'Hidden' }}</span></td><td class="admin-actions"><a href="{{ route('admin.categories.edit',$category) }}">Edit</a><x-admin.delete-form :action="route('admin.categories.destroy',$category)" /></td></tr>@empty<tr><td colspan="5" class="admin-empty">No categories found.</td></tr>@endforelse</tbody></table></div><div class="admin-pagination">{{ $categories->links() }}</div></section>
@endsection
