<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogRequest;
use App\Models\Blog;
use App\Models\BlogCategory;

class BlogController extends Controller
{
    public function index()
    {
        return view('admin.blogs.index', ['blogs' => Blog::with(['category', 'author'])->latest()->paginate(20)]);
    }

    public function create()
    {
        return view('admin.blogs.create', ['categories' => BlogCategory::where('is_active', true)->get()]);
    }

    public function store(BlogRequest $request)
    {
        $blog = Blog::create($request->validated() + ['author_id' => $request->user()->id]);

        return redirect()->route('admin.blogs.edit', $blog)->with('success', __('Blog created.'));
    }

    public function edit(Blog $blog)
    {
        return view('admin.blogs.edit', [
            'blog' => $blog,
            'categories' => BlogCategory::where('is_active', true)->get(),
        ]);
    }

    public function update(BlogRequest $request, Blog $blog)
    {
        $blog->update($request->validated());

        return back()->with('success', __('Blog updated.'));
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();

        return redirect()->route('admin.blogs.index')->with('success', __('Blog deleted.'));
    }
}
