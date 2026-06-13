<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;

class BlogController extends Controller
{
    public function urduIndex()
    {
        return $this->index('ur');
    }

    public function urduShow(string $slug)
    {
        return $this->show('ur', $slug);
    }

    public function englishIndex()
    {
        return $this->index('en');
    }

    public function englishShow(string $slug)
    {
        return $this->show('en', $slug);
    }

    public function index(string $language)
    {
        abort_unless(in_array($language, ['en', 'ur'], true), 404);

        return view('blogs.index', [
            'language' => $language,
            'blogs' => Blog::published()->where('language', $language)->with(['category', 'author'])->latest('published_at')->paginate(10),
            'categories' => BlogCategory::where('language', $language)->where('is_active', true)->get(),
        ]);
    }

    public function show(string $language, string $slug)
    {
        $blog = Blog::published()
            ->where('language', $language)
            ->where('slug', $slug)
            ->with(['category', 'author'])
            ->firstOrFail();

        return view('blogs.show', [
            'blog' => $blog,
            'language' => $language,
            'relatedBlogs' => Blog::published()
                ->where('language', $language)
                ->where('blog_category_id', $blog->blog_category_id)
                ->whereKeyNot($blog)
                ->latest('published_at')
                ->take(4)
                ->get(),
        ]);
    }
}
