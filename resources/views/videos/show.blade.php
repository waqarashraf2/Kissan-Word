@extends('layouts.app')
@section('title', ($video->meta_title ?: $video->title).' | KISANWORLD')
@section('meta_description', $video->meta_description ?: $video->description)
@section('canonical', $video->canonical_url ?: route('videos.show',$video))
@section('content')
<x-page-hero :eyebrow="$video->category ?: 'Agriculture video'" :title="$video->title" />
<section class="article-detail section-shell"><div class="video-frame"><iframe src="https://www.youtube-nocookie.com/embed/{{ $video->youtube_video_id }}" title="{{ $video->title }}" loading="lazy" allowfullscreen></iframe></div><div class="prose"><p>{{ $video->description }}</p></div></section>
@if($relatedVideos->isNotEmpty())<section class="inner-section section-shell"><div class="section-heading"><div><span class="section-kicker">Watch next</span><h2>Related videos</h2></div></div><div class="media-grid">@foreach($relatedVideos as $related)<x-video-card :video="$related" />@endforeach</div></section>@endif
@endsection
