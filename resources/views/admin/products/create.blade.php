@extends('layouts.admin')
@section('title', 'Add Product')
@section('heading', 'Add Product')
@section('content')
<div class="admin-page-heading"><div><h1>Create product</h1><p>Add catalog, stock, content and gallery information.</p></div><a class="admin-secondary" href="{{ route('admin.products.index') }}">Back</a></div>
<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="admin-form-stack">@csrf @include('admin.products.form')<div class="admin-form-actions"><button class="admin-primary">Create Product</button></div></form>
@endsection
