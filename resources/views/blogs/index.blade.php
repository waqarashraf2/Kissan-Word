@extends('layouts.app')
@section('lang', $language === 'ur' ? 'ur' : 'en')
@section('dir', $language === 'ur' ? 'rtl' : 'ltr')
@section('title', ($language === 'ur' ? 'زرعی مضامین' : 'Agriculture Articles').' | KISANWORLD')
@section('content')
<x-page-hero :eyebrow="$language === 'ur' ? 'کسان کی رہنمائی' : 'Field knowledge'" :title="$language === 'ur' ? 'اردو زرعی بلاگز' : 'English agriculture blogs'" :text="$language === 'ur' ? 'فصل، زمین اور جدید کاشتکاری کے بارے میں عملی رہنمائی۔' : 'Practical, field-ready knowledge for healthier crops and better decisions.'" />
<section class="inner-section section-shell"><div class="article-grid">@forelse($blogs as $blog)<x-blog-card :blog="$blog" />@empty<div class="empty-state"><strong>No articles published yet.</strong></div>@endforelse</div><div class="pagination-wrap">{{ $blogs->links() }}</div></section>
@endsection
