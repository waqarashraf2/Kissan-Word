@props(['eyebrow', 'title', 'text' => null])
<section class="page-hero">
    <div class="section-shell">
        <span class="section-kicker light">{{ $eyebrow }}</span>
        <h1>{{ $title }}</h1>
        @if ($text)<p>{{ $text }}</p>@endif
    </div>
</section>
