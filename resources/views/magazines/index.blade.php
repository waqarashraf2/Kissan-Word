@extends('layouts.app')
@section('title', 'KISANWORLD Magazines')
@section('content')
<x-page-hero eyebrow="Read & grow" title="KISANWORLD magazines" text="Seasonal agriculture insight, crop guidance and industry updates in one practical publication." />
<section class="inner-section section-shell"><div class="media-grid magazine-grid">@forelse($magazines as $magazine)<x-magazine-card :magazine="$magazine" />@empty<div class="empty-state"><strong>No magazines available yet.</strong></div>@endforelse</div><div class="pagination-wrap">{{ $magazines->links() }}</div></section>
@endsection
