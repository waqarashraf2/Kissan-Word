@extends('layouts.admin')
@section('title', 'Add Video')
@section('heading', 'Add Video')
@section('content')
<div class="admin-page-heading"><div><h1>Create video</h1></div><a class="admin-secondary" href="{{ route('admin.videos.index') }}">Back</a></div><form action="{{ route('admin.videos.store') }}" method="POST" class="admin-form-stack">@csrf @include('admin.videos.form')<div class="admin-form-actions"><button class="admin-primary">Create Video</button></div></form>
@endsection
