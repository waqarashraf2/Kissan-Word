@extends('layouts.admin')
@section('title', 'Add Blog Category')
@section('heading', 'Add Blog Category')
@section('content')
<div class="admin-page-heading"><div><h1>Create blog category</h1></div><a class="admin-secondary" href="{{ route('admin.blog-categories.index') }}">Back</a></div>
<form action="{{ route('admin.blog-categories.store') }}" method="POST" class="admin-form-stack">@csrf @include('admin.blog-categories.form')<div class="admin-form-actions"><button class="admin-primary">Create Category</button></div></form>
@endsection
