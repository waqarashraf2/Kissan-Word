@extends('layouts.app')
@section('title', 'Agricultural Products | KISANWORLD')
@section('meta_description', 'Browse fertilizers, seeds, pesticides, farming medicines and tools at KISANWORLD.')
@section('content')
<x-page-hero eyebrow="Agricultural store" title="Products for stronger farms" text="Browse trusted farm inputs with clear pricing, stock status and direct support." />
<section class="inner-section section-shell">
    <form class="catalog-toolbar" method="GET">
        <input type="search" name="q" value="{{ request('q') }}" placeholder="Search products..." aria-label="Search products">
        <select name="category" aria-label="Filter by category">
            <option value="">All categories</option>
            @foreach ($categories as $category)<option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>{{ $category->name }}</option>@endforeach
        </select>
        <button class="button button-primary">Search</button>
    </form>
    <div class="product-grid">@forelse ($products as $product)<x-product-card :product="$product" />@empty<div class="empty-state"><strong>No products found.</strong><span>Try another category or search term.</span></div>@endforelse</div>
    <div class="pagination-wrap">{{ $products->links() }}</div>
</section>
@endsection
