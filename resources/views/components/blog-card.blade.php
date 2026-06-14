@props(['blog'])
<article class="article-card reveal">
    <a href="{{ route($blog->language === 'ur' ? 'blogs.urdu.show' : 'blogs.english.show', $blog->slug) }}" class="article-image">
        @if($blog->featured_image_url)<img src="{{ $blog->featured_image_url }}" alt="{{ $blog->featured_image_alt ?: $blog->title }}" loading="lazy" width="700" height="440">@else<span>{{ $blog->language === 'ur' ? 'کسان ورلڈ' : 'KISANWORLD' }}</span>@endif
    </a>
    <div><span>{{ $blog->category?->name ?? 'Agriculture' }}</span><time>{{ $blog->published_at?->format('M d, Y') }}</time></div>
    <h3><a href="{{ route($blog->language === 'ur' ? 'blogs.urdu.show' : 'blogs.english.show', $blog->slug) }}">{{ $blog->title }}</a></h3>
</article>
