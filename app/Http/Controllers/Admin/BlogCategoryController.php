<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BlogCategoryController extends Controller
{
    public function index()
    {
        return view('admin.blog-categories.index', ['categories' => BlogCategory::latest()->paginate(30)]);
    }

    public function create()
    {
        return view('admin.blog-categories.create');
    }

    public function store(Request $request)
    {
        $category = BlogCategory::create($this->validated($request));

        return redirect()->route('admin.blog-categories.edit', $category)->with('success', __('Blog category created.'));
    }

    public function edit(BlogCategory $blogCategory)
    {
        return view('admin.blog-categories.edit', ['category' => $blogCategory]);
    }

    public function update(Request $request, BlogCategory $blogCategory)
    {
        $blogCategory->update($this->validated($request, $blogCategory));

        return back()->with('success', __('Blog category updated.'));
    }

    public function destroy(BlogCategory $blogCategory)
    {
        abort_if($blogCategory->blogs()->exists(), 422, 'Move related blogs before deleting this category.');
        $blogCategory->delete();

        return redirect()->route('admin.blog-categories.index')->with('success', __('Blog category deleted.'));
    }

    private function validated(Request $request, ?BlogCategory $category = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'name_ur' => ['nullable', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('blog_categories')->ignore($category?->id)],
            'language' => ['required', 'in:en,ur'],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ]);
    }
}
