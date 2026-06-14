@extends('layouts.admin')
@section('title', 'Videos')
@section('heading', 'Videos')
@section('content')
<div class="admin-page-heading"><div><h1>Videos</h1><p>Manage YouTube agriculture videos and SEO.</p></div><a class="admin-primary" href="{{ route('admin.videos.create') }}">Add Video</a></div>
<section class="admin-card"><div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Video</th><th>Category</th><th>Status</th><th>Published</th><th></th></tr></thead><tbody>@forelse($videos as $video)<tr><td><strong>{{ $video->title }}</strong><small>{{ $video->youtube_video_id }}</small></td><td>{{ $video->category }}</td><td><span class="admin-status {{ $video->is_active ? 'completed' : 'cancelled' }}">{{ $video->is_active ? 'Active' : 'Hidden' }}</span></td><td>{{ $video->published_at?->format('M d, Y') ?? 'Immediately' }}</td><td class="admin-actions"><a href="{{ route('videos.show',$video) }}" target="_blank">View</a><a href="{{ route('admin.videos.edit',$video) }}">Edit</a><x-admin.delete-form :action="route('admin.videos.destroy',$video)" /></td></tr>@empty<tr><td colspan="5" class="admin-empty">No videos found.</td></tr>@endforelse</tbody></table></div><div class="admin-pagination">{{ $videos->links() }}</div></section>
@endsection
