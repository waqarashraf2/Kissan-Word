@extends('layouts.admin')
@section('title', 'Add Article')
@section('heading', 'Add Article')
@section('content')
<div class="admin-page-heading"><div><h1>Create article</h1><p>Publish an Urdu or English agriculture article.</p></div><a class="admin-secondary" href="{{ route('admin.blogs.index') }}">Back</a></div>
<form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data" class="admin-form-stack">@csrf @include('admin.blogs.form')<div class="admin-form-actions"><button class="admin-primary">Create Article</button></div></form>
@endsection
