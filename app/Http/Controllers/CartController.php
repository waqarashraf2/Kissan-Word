<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = collect($request->session()->get('cart', []));
        $products = Product::active()->with('images')->whereIn('id', $cart->keys())->get();

        return view('cart.index', compact('cart', 'products'));
    }

    public function store(Request $request, Product $product)
    {
        abort_unless($product->is_active && $product->in_stock, 422);
        $data = $request->validate(['quantity' => ['required', 'integer', 'min:1', 'max:100']]);
        $cart = $request->session()->get('cart', []);
        $cart[$product->id] = min(100, ($cart[$product->id] ?? 0) + $data['quantity']);
        $request->session()->put('cart', $cart);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => __('Product added to cart.'),
                'cart_count' => array_sum($cart),
                'item_quantity' => $cart[$product->id],
            ]);
        }

        return back()->with('success', __('Product added to cart.'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate(['quantity' => ['required', 'integer', 'min:1', 'max:100']]);
        $cart = $request->session()->get('cart', []);
        $cart[$product->id] = $data['quantity'];
        $request->session()->put('cart', $cart);

        return back()->with('success', __('Cart updated.'));
    }

    public function destroy(Request $request, Product $product)
    {
        $cart = $request->session()->get('cart', []);
        unset($cart[$product->id]);
        $request->session()->put('cart', $cart);

        return back()->with('success', __('Product removed from cart.'));
    }
}
