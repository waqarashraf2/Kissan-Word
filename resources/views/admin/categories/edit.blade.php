@extends('layouts.admin')
@section('title', 'Edit Category')
@section('heading', 'Edit Category')
@section('content')
<div class="admin-page-heading"><div><h1>{{ $category->name }}</h1></div><a class="admin-secondary" href="{{ route('admin.categories.index') }}">Back</a></div>
<form action="{{ route('admin.categories.update',$category) }}" method="POST" class="admin-form-stack">@csrf @method('PUT') @include('admin.categories.form')<div class="admin-form-actions"><button class="admin-primary">Save Changes</button></div></form>
@endsection
