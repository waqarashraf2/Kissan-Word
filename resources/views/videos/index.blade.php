@extends('layouts.app')
@section('title', 'Agriculture Videos | KISANWORLD')
@section('content')
<x-page-hero eyebrow="Watch & learn" title="Agriculture videos" text="Practical crop guidance, product explainers and field knowledge in an easy video format." />
<section class="inner-section section-shell"><div class="media-grid">@forelse($videos as $video)<x-video-card :video="$video" />@empty<div class="empty-state"><strong>No videos published yet.</strong></div>@endforelse</div><div class="pagination-wrap">{{ $videos->links() }}</div></section>
@endsection
