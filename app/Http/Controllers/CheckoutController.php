<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Product;
use App\Services\OrderService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function create(Request $request)
    {
        $cart = collect($request->session()->get('cart', []));
        $products = Product::active()->with('images')->whereIn('id', $cart->keys())->get();

        return view('checkout.create', compact('cart', 'products'));
    }

    public function store(CheckoutRequest $request, OrderService $orders)
    {
        $order = $orders->place($request->validated(), $request->user());
        $request->session()->forget('cart');

        return redirect()->route('checkout.success', $order->order_number);
    }

    public function success(string $orderNumber)
    {
        return view('checkout.success', compact('orderNumber'));
    }
}
