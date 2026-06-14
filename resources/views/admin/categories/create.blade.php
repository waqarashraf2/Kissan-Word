@extends('layouts.admin')
@section('title', 'Add Category')
@section('heading', 'Add Category')
@section('content')
<div class="admin-page-heading"><div><h1>Create category</h1></div><a class="admin-secondary" href="{{ route('admin.categories.index') }}">Back</a></div>
<form action="{{ route('admin.categories.store') }}" method="POST" class="admin-form-stack">@csrf @include('admin.categories.form')<div class="admin-form-actions"><button class="admin-primary">Create Category</button></div></form>
@endsection
