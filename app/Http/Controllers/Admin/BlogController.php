<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogRequest;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Support\RichTextSanitizer;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function __construct(private readonly RichTextSanitizer $sanitizer) {}

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
        $data = $request->validated();
        $image = Arr::pull($data, 'featured_image_file');
        Arr::forget($data, 'remove_featured_image');
        $data['content'] = $this->sanitizer->sanitize($data['content']);

        if ($image) {
            $data['featured_image'] = $image->store('uploads/blogs', 'public');
        }

        $blog = Blog::create($data + ['author_id' => $request->user()->id]);

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
        $data = $request->validated();
        $image = Arr::pull($data, 'featured_image_file');
        $removeImage = (bool) Arr::pull($data, 'remove_featured_image', false);
        $oldImage = $blog->featured_image;
        $data['content'] = $this->sanitizer->sanitize($data['content']);

        if ($image) {
            $data['featured_image'] = $image->store('uploads/blogs', 'public');
        } elseif ($removeImage) {
            $data['featured_image'] = null;
        }

        $blog->update($data);

        if (($image || $removeImage) && str_starts_with((string) $oldImage, 'uploads/')) {
            Storage::disk('public')->delete($oldImage);
        }

        return back()->with('success', __('Blog updated.'));
    }

    public function destroy(Blog $blog)
    {
        if (str_starts_with((string) $blog->featured_image, 'uploads/')) {
            Storage::disk('public')->delete($blog->featured_image);
        }
        $blog->delete();

        return redirect()->route('admin.blogs.index')->with('success', __('Blog deleted.'));
    }
}
