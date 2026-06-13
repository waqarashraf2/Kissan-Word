<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return view('admin.orders.index', ['orders' => Order::latest()->paginate(30)]);
    }

    public function show(Order $order)
    {
        return view('admin.orders.show', ['order' => $order->load(['items.product', 'user'])]);
    }

    public function update(Request $request, Order $order)
    {
        $order->update($request->validate([
            'status' => ['required', 'in:pending,confirmed,processing,shipped,completed,cancelled'],
            'payment_status' => ['required', 'in:pending,paid,failed,refunded'],
        ]));

        return back()->with('success', __('Order updated.'));
    }
}
