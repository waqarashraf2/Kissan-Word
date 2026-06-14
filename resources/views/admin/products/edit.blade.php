@extends('layouts.admin')
@section('title', 'Edit Product')
@section('heading', 'Edit Product')
@section('content')
<div class="admin-page-heading"><div><h1>{{ $product->name }}</h1><p>Update catalog, stock, content and gallery information.</p></div><div class="admin-actions"><a class="admin-secondary" href="{{ route('products.show',$product) }}" target="_blank">View Product</a><a class="admin-secondary" href="{{ route('admin.products.index') }}">Back</a></div></div>
<form action="{{ route('admin.products.update',$product) }}" method="POST" enctype="multipart/form-data" class="admin-form-stack">@csrf @method('PUT') @include('admin.products.form')<div class="admin-form-actions"><button class="admin-primary">Save Changes</button></div></form>
@endsection
