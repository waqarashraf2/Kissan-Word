@extends('layouts.admin')
@section('title', 'Edit Article')
@section('heading', 'Edit Article')
@section('content')
<div class="admin-page-heading"><div><h1>{{ $blog->title }}</h1></div><a class="admin-secondary" href="{{ route('admin.blogs.index') }}">Back</a></div>
<form action="{{ route('admin.blogs.update',$blog) }}" method="POST" enctype="multipart/form-data" class="admin-form-stack">@csrf @method('PUT') @include('admin.blogs.form')<div class="admin-form-actions"><button class="admin-primary">Save Changes</button></div></form>
@endsection
