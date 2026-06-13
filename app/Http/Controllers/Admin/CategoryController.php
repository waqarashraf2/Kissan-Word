<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories.index', ['categories' => Category::with('parent')->orderBy('sort_order')->paginate(30)]);
    }

    public function create()
    {
        return view('admin.categories.create', ['parents' => Category::whereNull('parent_id')->get()]);
    }

    public function store(Request $request)
    {
        $category = Category::create($this->validated($request));

        return redirect()->route('admin.categories.edit', $category)->with('success', __('Category created.'));
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', [
            'category' => $category,
            'parents' => Category::whereNull('parent_id')->whereKeyNot($category)->get(),
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $category->update($this->validated($request, $category));

        return back()->with('success', __('Category updated.'));
    }

    public function destroy(Category $category)
    {
        abort_if($category->products()->exists() || $category->children()->exists(), 422, 'Move related records before deleting this category.');
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', __('Category deleted.'));
    }

    private function validated(Request $request, ?Category $category = null): array
    {
        return $request->validate([
            'parent_id' => ['nullable', 'exists:categories,id', Rule::notIn([$category?->id])],
            'name' => ['required', 'string', 'max:255'],
            'name_ur' => ['nullable', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('categories')->ignore($category?->id)],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['integer', 'min:0'],
            'is_active' => ['boolean'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'canonical_url' => ['nullable', 'url', 'max:255'],
        ]);
    }
}
