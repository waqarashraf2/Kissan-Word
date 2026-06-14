@extends('layouts.admin')
@section('title', 'Blog Categories')
@section('heading', 'Blog Categories')
@section('content')
<div class="admin-page-heading"><div><h1>Blog categories</h1><p>Separate Urdu and English content topics.</p></div><a class="admin-primary" href="{{ route('admin.blog-categories.create') }}">Add Category</a></div>
<section class="admin-card"><div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Name</th><th>Language</th><th>Status</th><th></th></tr></thead><tbody>@forelse($categories as $category)<tr><td><strong>{{ $category->name }}</strong><small>{{ $category->name_ur }}</small></td><td>{{ strtoupper($category->language) }}</td><td><span class="admin-status {{ $category->is_active ? 'completed' : 'cancelled' }}">{{ $category->is_active ? 'Active' : 'Hidden' }}</span></td><td class="admin-actions"><a href="{{ route('admin.blog-categories.edit',$category) }}">Edit</a><x-admin.delete-form :action="route('admin.blog-categories.destroy',$category)" /></td></tr>@empty<tr><td colspan="4" class="admin-empty">No blog categories found.</td></tr>@endforelse</tbody></table></div><div class="admin-pagination">{{ $categories->links() }}</div></section>
@endsection
