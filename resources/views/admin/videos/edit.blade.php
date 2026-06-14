@extends('layouts.admin')
@section('title', 'Edit Video')
@section('heading', 'Edit Video')
@section('content')
<div class="admin-page-heading"><div><h1>{{ $video->title }}</h1></div><a class="admin-secondary" href="{{ route('admin.videos.index') }}">Back</a></div><form action="{{ route('admin.videos.update',$video) }}" method="POST" class="admin-form-stack">@csrf @method('PUT') @include('admin.videos.form')<div class="admin-form-actions"><button class="admin-primary">Save Changes</button></div></form>
@endsection
