<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::active()
            ->with(['category', 'images'])
            ->when($request->filled('category'), fn ($query) => $query->whereHas('category', fn ($q) => $q->where('slug', $request->string('category'))))
            ->when($request->filled('q'), fn ($query) => $query->where(fn ($q) => $q
                ->where('name', 'like', '%'.$request->string('q').'%')
                ->orWhere('name_ur', 'like', '%'.$request->string('q').'%')))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('products.index', [
            'products' => $products,
            'categories' => Category::whereNull('parent_id')->where('is_active', true)->with('children')->get(),
        ]);
    }

    public function show(Product $product)
    {
        abort_unless($product->is_active, 404);

        return view('products.show', [
            'product' => $product->load(['category', 'images']),
            'relatedProducts' => Product::active()
                ->where('category_id', $product->category_id)
                ->whereKeyNot($product)
                ->with('images')
                ->take(4)
                ->get(),
        ]);
    }
}
