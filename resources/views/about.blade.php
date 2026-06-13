@extends('layouts.app')

@section('title', 'About KISANWORLD | Agriculture Platform Pakistan')
@section('meta_description', 'Learn how KISANWORLD Marketing Lahore connects Pakistan’s farmers with agricultural products, practical knowledge, videos and magazines.')
@section('canonical', route('about'))

@section('content')
<x-page-hero eyebrow="About KISANWORLD" :title="$siteSettings['about_title'] ?? 'Products, knowledge and support for better farming.'" text="An agriculture-focused commerce and learning platform serving farmers across Pakistan." />

<section class="about-section section-shell">
    <div class="about-copy reveal">
        <span class="section-kicker">Who we are</span>
        <h2>Farmer-friendly information, dependable products and nationwide reach.</h2>
        <p>{{ $siteSettings['about_intro'] ?? 'KISANWORLD Marketing is an agriculture-focused platform based in Lahore.' }}</p>
        <p>{{ $siteSettings['about_distribution'] ?? 'We support farmers through products and practical digital agriculture information.' }}</p>
        <p>{{ $siteSettings['about_commitment'] ?? 'We aim to present clear information and responsible usage guidance.' }}</p>
    </div>
    <aside class="about-facts reveal">
        <div><strong>Lahore</strong><span>Based in Pakistan</span></div>
        <div><strong>Nationwide</strong><span>Goods transport support</span></div>
        <div><strong>Urdu + English</strong><span>Practical agriculture content</span></div>
        <div><strong>0322 6780242</strong><span>WhatsApp information & booking</span></div>
    </aside>
</section>

<section class="about-values">
    <div class="section-shell trust-grid">
        <div class="trust-intro reveal"><span class="section-kicker light">Our approach</span><h2>Clear information.<br>Responsible guidance.</h2></div>
        <div class="trust-item reveal"><strong>01</strong><h3>Useful Knowledge</h3><p>Practical agriculture articles and videos in formats farmers can easily access.</p></div>
        <div class="trust-item reveal"><strong>02</strong><h3>Product Clarity</h3><p>Pricing, stock, application information and important cautions presented clearly.</p></div>
        <div class="trust-item reveal"><strong>03</strong><h3>Direct Support</h3><p>Phone and WhatsApp contact for product information, booking and order assistance.</p></div>
    </div>
</section>
@endsection
