<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.products.index', ['products' => Product::with('category')->latest()->paginate(20)]);
    }

    public function create()
    {
        return view('admin.products.create', ['categories' => Category::where('is_active', true)->get()]);
    }

    public function store(ProductRequest $request)
    {
        $product = DB::transaction(function () use ($request) {
            $data = $request->validated();
            $images = $this->normalizeImages(Arr::pull($data, 'images', []));
            $product = Product::create($data);
            $product->images()->createMany($images);

            return $product;
        });

        return redirect()->route('admin.products.edit', $product)->with('success', __('Product created.'));
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', [
            'product' => $product->load('images'),
            'categories' => Category::where('is_active', true)->get(),
        ]);
    }

    public function update(ProductRequest $request, Product $product)
    {
        DB::transaction(function () use ($request, $product): void {
            $data = $request->validated();
            $images = Arr::pull($data, 'images');
            $product->update($data);
            if ($images !== null) {
                $product->images()->delete();
                $product->images()->createMany($this->normalizeImages($images));
            }
        });

        return back()->with('success', __('Product updated.'));
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', __('Product deleted.'));
    }

    private function normalizeImages(array $images): array
    {
        if ($images === []) {
            return [];
        }

        $primaryIndex = collect($images)->search(fn (array $image) => filter_var($image['is_primary'] ?? false, FILTER_VALIDATE_BOOL));
        $primaryIndex = $primaryIndex === false ? 0 : $primaryIndex;

        return collect($images)
            ->values()
            ->map(fn (array $image, int $index) => [
                'path' => $image['path'],
                'alt_text' => $image['alt_text'] ?? null,
                'sort_order' => $image['sort_order'] ?? $index,
                'is_primary' => $index === $primaryIndex,
            ])
            ->sortBy('sort_order')
            ->values()
            ->all();
    }
}
